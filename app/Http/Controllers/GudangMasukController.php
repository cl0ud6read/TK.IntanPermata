<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\HasilProduksi;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GudangMasukController extends Controller
{
    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function purchaseIndex()
    {
        $purchases = Purchase::where('status', 'pending')->with('supplier')->latest()->paginate(10);
        return view('pages.gudang.masuk.purchase_index', compact('purchases'));
    }

    public function approvePurchase(Request $request, Purchase $purchase)
    {
        if ($purchase->status !== 'pending') {
            return back()->with('error', 'Purchase is not pending.');
        }

        try {
            $batchId = (string) Str::uuid();

            foreach ($purchase->items as $item) {
                $this->stockService->processMovement(
                    $batchId,
                    Purchase::class,
                    $purchase->id,
                    'purchase_approval',
                    'bahan_baku',
                    $item->bahan_baku_id,
                    'in',
                    $item->quantity,
                    'Penerimaan barang dari PO ' . $purchase->invoice_number,
                    auth()->id()
                );
            }

            $purchase->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            return redirect()->route('gudang.masuk.purchase')->with('success', 'Penerimaan barang berhasil diproses.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function hasilProduksiIndex()
    {
        $hasilProduksis = HasilProduksi::where('status', 'pending_gudang')->with(['produksi', 'product'])->latest()->paginate(10);
        return view('pages.gudang.masuk.hasil_produksi_index', compact('hasilProduksis'));
    }

    public function approveHasilProduksi(Request $request, HasilProduksi $hasilProduksi)
    {
        if ($hasilProduksi->status !== 'pending_gudang') {
            return back()->with('error', 'Hasil produksi tidak valid.');
        }

        try {
            $batchId = (string) Str::uuid();

            // Receive good products
            if ($hasilProduksi->quantity_produced > 0) {
                $this->stockService->processMovement(
                    $batchId,
                    HasilProduksi::class,
                    $hasilProduksi->id,
                    'production_yield',
                    'product',
                    $hasilProduksi->product_id,
                    'in',
                    $hasilProduksi->quantity_produced,
                    'Penerimaan hasil produksi ' . $hasilProduksi->produksi->production_number,
                    auth()->id()
                );
            }

            $hasilProduksi->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            return redirect()->route('gudang.masuk.produksi')->with('success', 'Hasil produksi berhasil diterima di gudang.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
