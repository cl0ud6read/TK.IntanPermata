<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Product;
use App\Services\StockService;
use App\Enums\AdjustmentType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Str;

class StockAdjustmentController extends Controller
{
    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function create()
    {
        $bahanBakus = BahanBaku::all();
        $products = Product::all();
        $adjustmentTypes = AdjustmentType::cases();
        return view('pages.gudang.adjustment.create', compact('bahanBakus', 'products', 'adjustmentTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_type' => 'required|in:bahan_baku,product',
            'item_id' => 'required|integer',
            'adjustment_type' => ['required', new Enum(AdjustmentType::class)],
            'movement_type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'notes' => 'required|string', // Mandatory as requested
        ]);

        try {
            $batchId = (string) Str::uuid();

            // Just using auth()->user() as the reference_id since it's a manual action
            $this->stockService->processMovement(
                $batchId,
                get_class(auth()->user()),
                auth()->id(),
                'manual_adjustment',
                $request->item_type,
                $request->item_id,
                $request->movement_type,
                $request->quantity,
                $request->adjustment_type . ': ' . $request->notes,
                auth()->id()
            );

            return redirect()->route('gudang.adjustment.create')->with('success', 'Penyesuaian stok berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
}
