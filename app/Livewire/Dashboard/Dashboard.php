<?php

namespace App\Livewire\Dashboard;

use Carbon\Carbon;
use Livewire\Component;
use App\Enums\DatePeriod;
use App\Services\DashboardStatsService;

class Dashboard extends Component
{
    public string $dateFilter = DatePeriod::TODAY->value;
    public ?string $customStartDate = null;
    public ?string $customEndDate = null;

    public array $stats = [];
    public array $lowStockProducts = [];
    public array $recentSales = [];
    public array $topProducts = [];
    public array $topCustomers = [];
    public int $produksiTertunda = 0;
    public int $produksiBerjalan = 0;
    public int $produksiSelesai = 0;
    
    public int $totalStokProduk = 0;
    public int $totalStokBahan = 0;
    public int $stokMasuk = 0;
    public int $stokKeluar = 0;

    // Charts Data
    public array $salesChart = [];
    public array $cashFlowChart = [];
    public array $expenseChart = [];

    public function mount(DashboardStatsService $service)
    {
        $this->loadStats($service);
    }

    public function updatedDateFilter()
    {
        // If Custom is selected, we wait for dates.
        if ($this->dateFilter !== DatePeriod::CUSTOM->value) {
            $this->loadStats(app(DashboardStatsService::class));
        }
    }

    public function updateCustomRange($startDate, $endDate)
    {
        $this->customStartDate = $startDate;
        $this->customEndDate = $endDate;

        if ($this->dateFilter === DatePeriod::CUSTOM->value) {
            $this->loadStats(app(DashboardStatsService::class));
        }
    }

    public function loadStats(DashboardStatsService $service)
    {
        [$startDate, $endDate] = $this->getDateRange();

        // 1. Sales Stats
        $salesStats = $service->getSalesStats($startDate, $endDate, $this->dateFilter);

        // 2. Cash Flow Stats
        $cashFlowStats = $service->getCashFlowStats($startDate, $endDate, $this->dateFilter);


        $this->stats = [
            'total_sales' => $salesStats['total_revenue'],
            'sales_count' => $salesStats['count'],
            'gross_profit' => $salesStats['gross_profit'],
            'income' => $cashFlowStats['income'],
            'expense' => $cashFlowStats['expense'],
            'net_cash_flow' => $cashFlowStats['net_cash_flow'],
        ];

        // 3. Lists
        $this->lowStockProducts = $service->getLowStockProducts(5);
        $this->topProducts = $service->getTopProducts($startDate, $endDate, 5);
        $this->recentSales = $service->getRecentSales(5);
        $this->topCustomers = $service->getTopCustomers($startDate, $endDate, 5);

        // Production Stats
        $this->produksiTertunda = \App\Models\Produksi::where('status', 'pending')->count();
        $this->produksiBerjalan = \App\Models\Produksi::where('status', 'processing')->count();
        $this->produksiSelesai = \App\Models\Produksi::where('status', 'completed')
            ->whereBetween('updated_at', [$startDate, $endDate])->count();

        // Warehouse Stats
        $this->totalStokProduk = \App\Models\Product::sum('quantity') ?? 0;
        $this->totalStokBahan = \App\Models\BahanBaku::sum('quantity') ?? 0;
        $this->stokMasuk = \App\Models\StockMovement::where('type', 'in')
            ->whereBetween('movement_date', [$startDate, $endDate])->sum('quantity') ?? 0;
        $this->stokKeluar = \App\Models\StockMovement::where('type', 'out')
            ->whereBetween('movement_date', [$startDate, $endDate])->sum('quantity') ?? 0;

        // 4. Prepare Chart Data
        $salesTrend = $service->getSalesTrend($startDate, $endDate);

        $this->salesChart = [
            'labels' => array_keys($salesTrend),
            'data' => array_values($salesTrend),
        ];

        $cashFlowTrend = $service->getCashFlowTrend($startDate, $endDate);

        $this->cashFlowChart = [
            'labels' => array_keys($cashFlowTrend['income']),
            'income' => array_values($cashFlowTrend['income']),
            'expense' => array_values($cashFlowTrend['expense']),
        ];

        $expenseBreakdown = $service->getExpenseBreakdown($startDate, $endDate);
        $this->expenseChart = [
            'labels' => array_column($expenseBreakdown, 'category_name'),
            'series' => array_column($expenseBreakdown, 'total_amount'),
        ];

        $this->dispatch('stats-updated', [
            'sales' => $this->salesChart,
            'cashFlow' => $this->cashFlowChart,
            'expense' => $this->expenseChart,
        ]);
    }

    protected function getDateRange(): array
    {
        $now = Carbon::now();

        return match(DatePeriod::tryFrom($this->dateFilter)) {
            DatePeriod::TODAY => [$now->copy()->startOfDay(), $now->copy()->endOfDay()],
            DatePeriod::YESTERDAY => [$now->copy()->subDay()->startOfDay(), $now->copy()->subDay()->endOfDay()],
            DatePeriod::THIS_WEEK => [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()],
            DatePeriod::THIS_MONTH => [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()],
            DatePeriod::LAST_MONTH => [$now->copy()->subMonth()->startOfMonth(), $now->copy()->subMonth()->endOfMonth()],
            DatePeriod::CUSTOM => [
                Carbon::parse($this->customStartDate)->startOfDay(),
                Carbon::parse($this->customEndDate)->endOfDay()
            ],
            default => [$now->copy()->startOfDay(), $now->copy()->endOfDay()],
        };
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard');
    }
}
