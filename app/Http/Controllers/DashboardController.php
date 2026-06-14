<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request, $role = null)
    {
        if ($role && $role !== auth()->user()->role) {
            abort(403, 'Unauthorized. URL role does not match your role.');
        }

        $startDate = $request->input('start_date', now()->subDays(30)->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        // Reorder Alerts
        $lowStockBahanBaku = \App\Models\BahanBaku::where('is_below_min_stock', true)->get();
        $lowStockProducts = \App\Models\Product::where('is_below_min_stock', true)->get();

        // Production Metrics
        $activeProductions = \App\Models\Produksi::whereNotIn('status', \App\Models\Produksi::TERMINAL_STATES)->count();
        $completedProductions = \App\Models\Produksi::where('status', 'completed')
            ->whereBetween('updated_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->count();

        // Inventory Turnover Ratio Proxy (COGS / Average Inventory) - Simplified for this demo
        // We'll calculate total outbound quantity of products over total stock
        $totalOutbound = \App\Models\StockMovement::where('item_type', 'product')
            ->where('type', 'out')
            ->whereBetween('movement_date', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('quantity');

        $currentProductStock = \App\Models\Product::sum('quantity');
        
        $inventoryTurnover = $currentProductStock > 0 ? round($totalOutbound / $currentProductStock, 2) : 0;

        return view('dashboard', compact(
            'lowStockBahanBaku',
            'lowStockProducts',
            'activeProductions',
            'completedProductions',
            'inventoryTurnover',
            'startDate',
            'endDate'
        ));
    }
}
