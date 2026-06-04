<?php

namespace App\Http\Controllers;

use App\Models\Bom;
use App\Models\BahanBaku;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BOMController extends Controller
{
    public function index()
    {
        $boms = Bom::with('product')->latest()->paginate(10);
        return view('pages.bom.index', compact('boms'));
    }

    public function create()
    {
        $products = Product::all();
        $bahanBakus = BahanBaku::all();
        return view('pages.bom.create', compact('products', 'bahanBakus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'bahan_baku_id' => 'required|array|min:1',
            'bahan_baku_id.*' => 'required|exists:bahan_bakus,id',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            // Deactivate other BOMs for this product if needed (optional logic, but typically one active BOM per product)
            Bom::where('product_id', $request->product_id)->update(['is_active' => false]);

            $bom = Bom::create([
                'product_id' => $request->product_id,
                'name' => $request->name,
                'notes' => $request->notes,
                'is_active' => true,
            ]);

            foreach ($request->bahan_baku_id as $index => $bahanBakuId) {
                $bom->items()->create([
                    'bahan_baku_id' => $bahanBakuId,
                    'quantity' => $request->quantity[$index],
                ]);
            }
        });

        return redirect()->route('bom.index')->with('success', 'BOM berhasil ditambahkan.');
    }

    public function show(Bom $bom)
    {
        $bom->load(['product', 'items.bahanBaku']);
        return view('pages.bom.show', compact('bom'));
    }

    public function destroy(Bom $bom)
    {
        $bom->delete();
        return redirect()->route('bom.index')->with('success', 'BOM berhasil dihapus.');
    }
}
