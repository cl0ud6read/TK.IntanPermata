<?php

namespace App\Http\Controllers;

use App\Models\DetailProduksi;
use App\Models\Sale;
use App\Services\StockService;
use App\Services\FinanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GudangKeluarController extends Controller
{
    protected $stockService;
    protected $financeService;

    public function __construct(StockService $stockService, FinanceService $financeService)
    {
        $this->stockService = $stockService;
        $this->financeService = $financeService;
    }

    public function detailProduksiIndex()
    {
        $details = DetailProduksi::where('status', 'pending')->with(['produksi', 'bahanBaku'])->latest()->paginate(10);
        return view('pages.gudang.keluar.produksi_index', compact('details'));
    }

    public function approveDetailProduksi(Request $request, DetailProduksi $detailProduksi)
    {
        if ($detailProduksi->status !== 'pending') {
            return back()->with('error', 'Request material is not pending.');
        }

        try {
            $batchId = (string) Str::uuid();

            // Deduct stock
            $this->stockService->processMovement(
                $batchId,
                DetailProduksi::class,
                $detailProduksi->id,
                'production_usage',
                'bahan_baku',
                $detailProduksi->bahan_baku_id,
                'out',
                $detailProduksi->quantity_requested,
                'Pengeluaran bahan baku untuk produksi ' . $detailProduksi->produksi->production_number,
                auth()->id()
            );

            $detailProduksi->update([
                'status' => 'approved',
                'quantity_approved' => $detailProduksi->quantity_requested,
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            return redirect()->route('gudang.keluar.produksi')->with('success', 'Bahan baku berhasil didispatch ke produksi.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function saleIndex()
    {
        $sales = Sale::where('status', 'pending')->with('customer')->latest()->paginate(10);
        return view('pages.gudang.keluar.sale_index', compact('sales'));
    }

    public function approveSale(Request $request, Sale $sale)
    {
        if ($sale->status !== 'pending') {
            return back()->with('error', 'Sale is not pending.');
        }

        try {
            $batchId = (string) Str::uuid();

            foreach ($sale->items as $item) {
                $this->stockService->processMovement(
                    $batchId,
                    Sale::class,
                    $sale->id,
                    'sales_deduction',
                    'product',
                    $item->product_id,
                    'out',
                    $item->quantity,
                    'Pengeluaran barang jadi untuk invoice ' . $sale->invoice_number,
                    auth()->id()
                );
            }

            $sale->update([
                'status' => 'completed',
                // Assuming sale has a processed_by or similar, else just update status
            ]);

            // Sync with Finance (Income recorded upon dispatch)
            $this->financeService->recordIncomeFromSale($sale);

            return redirect()->route('gudang.keluar.sale')->with('success', 'Barang jualan berhasil dikeluarkan dari gudang.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
