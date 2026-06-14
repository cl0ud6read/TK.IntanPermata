<?php

namespace App\Http\Controllers\Api;

use App\Models\BahanBaku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class BahanBakuController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q') ?? $request->input('search');

        $cacheKey = 'bahan_baku_search_' . md5($query);

        $bahanBakus = Cache::remember($cacheKey, 300, function () use ($query) {
            return BahanBaku::query()
                ->with(['unit'])
                //->where('is_active', true) // Assuming there might be an active flag, if not just remove
                ->when($query, function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('sku', 'like', "%{$query}%");
                })
                ->limit(50)
                ->get()
                ->map(function ($bahan) {
                    return [
                        'value' => $bahan->id,
                        'id' => $bahan->id,
                        'text' => $bahan->name,
                        'name' => $bahan->name,
                        'price' => $bahan->purchase_price,
                        'selling_price' => $bahan->selling_price ?? 0, // usually bahan baku doesn't have selling price, but just in case
                        'sku' => $bahan->sku,
                        'quantity' => $bahan->quantity,
                        'unit' => $bahan->unit ? [
                            'symbol' => $bahan->unit->symbol,
                            'name' => $bahan->unit->name
                        ] : null,
                    ];
                });
        });

        return response()->json($bahanBakus);
    }
}
