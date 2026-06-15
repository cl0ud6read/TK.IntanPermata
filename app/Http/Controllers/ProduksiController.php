<?php

namespace App\Http\Controllers;

use App\Models\Produksi;
use App\Models\Product;
use App\Models\Bom;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProduksiController extends Controller
{
    public function index()
    {
        $produksis = Produksi::with(['product', 'creator'])->latest()->paginate(10);
        return view('pages.produksi.index', compact('produksis'));
    }

    public function create()
    {
        $products = Product::whereHas('boms', function($q) {
            $q->where('is_active', true);
        })->get();
        return view('pages.produksi.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'target_quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
            'start_date' => 'nullable|date',
        ]);

        $bom = Bom::where('product_id', $request->product_id)->where('is_active', true)->firstOrFail();

        $produksi = Produksi::create([
            'production_number' => 'PRD-' . strtoupper(Str::random(6)),
            'product_id' => $request->product_id,
            'bom_id' => $bom->id,
            'target_quantity' => $request->target_quantity,
            'status' => Produksi::INITIAL_STATE,
            'start_date' => $request->start_date ?? now(),
            'notes' => $request->notes,
            'created_by' => auth()->id(),
        ]);

        // Request materials automatically based on BOM
        foreach ($bom->items as $item) {
            $produksi->detailProduksi()->create([
                'bahan_baku_id' => $item->bahan_baku_id,
                'quantity_requested' => $item->quantity * $request->target_quantity,
                'status' => 'pending',
            ]);
        }

        return redirect()->route('produksi.show', $produksi)->with('success', 'Produksi berhasil dibuat dan bahan baku telah direquest ke gudang.');
    }

    public function show(Produksi $produksi)
    {
        $produksi->load(['product', 'bom', 'creator', 'detailProduksi.bahanBaku', 'hasilProduksi']);
        return view('pages.produksi.show', compact('produksi'));
    }

    public function updateStatus(Request $request, Produksi $produksi)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        try {
            $produksi->status = $request->status;
            $produksi->save(); // Observer will validate transition

            // Generate HasilProduksi if completed
            if ($request->status === 'completed' && $produksi->hasilProduksi()->count() === 0) {
                $produksi->hasilProduksi()->create([
                    'product_id' => $produksi->product_id,
                    'quantity_produced' => $produksi->target_quantity,
                    'quantity_defect' => 0,
                    'status' => 'pending_gudang'
                ]);
            }

            return back()->with('success', 'Status produksi diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
