<div>
    <div class="space-y-6">
        <!-- Filter Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-card p-4 rounded-lg border border-border shadow-sm">
        <div>
            <h2 class="text-lg font-semibold text-foreground">Ringkasan</h2>
            <p class="text-sm text-muted-foreground">Pantau kinerja bisnis Anda sekilas.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <!-- Period Selector -->
            <select wire:model.live="dateFilter" class="h-9 w-[180px] rounded-md border border-input bg-background px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring">
                @foreach(\App\Enums\DatePeriod::cases() as $period)
                    <option value="{{ $period->value }}">{{ $period->label() }}</option>
                @endforeach
            </select>

            <!-- Custom Date Range -->
            <!-- Custom Date Range (Flatpickr) -->
            <div x-show="$wire.dateFilter === 'custom'" x-transition class="flex items-center gap-2"
                 x-data="{
                     init() {
                         flatpickr(this.$refs.picker, {
                             mode: 'range',
                             dateFormat: 'Y-m-d',
                             locale: {
                                 weekdays: {
                                     shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                                     longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],         
                                 },
                                 months: {
                                     shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                                     longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                                 },
                                 firstDayOfWeek: 1,
                                 rangeSeparator: ' hingga '
                             },
                             defaultDate: [this.$wire.customStartDate, this.$wire.customEndDate],
                             onChange: (selectedDates, dateStr, instance) => {
                                 if (selectedDates.length === 2) {
                                     this.$wire.updateCustomRange(
                                         instance.formatDate(selectedDates[0], 'Y-m-d'),
                                         instance.formatDate(selectedDates[1], 'Y-m-d')
                                     );
                                 }
                             }
                         });
                     }
                 }"
            >
                <input x-ref="picker" type="text" class="h-9 w-[240px] rounded-md border border-input bg-background px-3 py-1 text-sm shadow-sm focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring" placeholder="Pilih rentang tanggal...">
            </div>

             <!-- Refresh Button -->
             <button wire:click="$refresh" class="print:hidden inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 w-9">
                <x-heroicon-o-arrow-path wire:loading.class="animate-spin" class="h-4 w-4" />
            </button>
            
            <!-- Print Button -->
            <button onclick="window.print()" class="print:hidden inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-9 px-4 py-2 gap-2">
                <x-heroicon-o-printer class="h-4 w-4" />
                <span class="hidden sm:inline">Cetak Laporan</span>
            </button>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3 print-grid-2">
        @if(in_array(auth()->user()->role, ['admin', 'manager']))
        <!-- Total Sales -->
        <div class="rounded-xl border bg-card text-card-foreground shadow-sm">
            <div class="p-4 flex flex-row items-center justify-between space-y-0 pb-2">
                <h3 class="tracking-tight text-sm font-medium">Total Nilai Faktur</h3>
                <x-heroicon-o-banknotes class="h-4 w-4 text-muted-foreground" />
            </div>
            <div class="p-4 pt-0">
                <div class="text-xl sm:text-2xl font-bold">
                    @money($stats['total_sales'] ?? 0)
                </div>
                <p class="text-xs text-muted-foreground mt-1">
                    {{ $stats['sales_count'] ?? 0 }} transaksi
                </p>
            </div>
        </div>

        <!-- Gross Profit -->
        <div class="rounded-xl border bg-card text-card-foreground shadow-sm">
            <div class="p-4 flex flex-row items-center justify-between space-y-0 pb-2">
                <h3 class="tracking-tight text-sm font-medium">Laba Kotor</h3>
                <x-heroicon-o-arrow-trending-up class="h-4 w-4 text-muted-foreground" />
            </div>
            <div class="p-4 pt-0">
                <div class="text-xl sm:text-2xl font-bold">
                    @money($stats['gross_profit'] ?? 0)
                </div>
                <p class="text-xs text-muted-foreground mt-1">
                    Estimasi berdasarkan HPP
                </p>
            </div>
        </div>

        <!-- Net Cash Flow -->
        <div class="rounded-xl border bg-card text-card-foreground shadow-sm">
            <div class="p-4 flex flex-row items-center justify-between space-y-0 pb-2">
                <h3 class="tracking-tight text-sm font-medium">Arus Kas Bersih</h3>
                 <x-heroicon-o-currency-dollar class="h-4 w-4 text-muted-foreground" />
            </div>
            <div class="p-4 pt-0">
                <div class="text-xl sm:text-2xl font-bold {{ ($stats['net_cash_flow'] ?? 0) >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                    @money($stats['net_cash_flow'] ?? 0)
                </div>
                <div class="flex justify-between text-[11px] sm:text-xs text-muted-foreground mt-1">
                    <span class="text-emerald-600 flex items-center gap-1" title="Total Pemasukan">
                        <x-heroicon-s-arrow-up class="w-3 h-3" /> @money($stats['income'] ?? 0)
                    </span>
                    <span class="text-red-600 flex items-center gap-1" title="Total Pengeluaran">
                        <x-heroicon-s-arrow-down class="w-3 h-3" /> @money($stats['expense'] ?? 0)
                    </span>
                </div>
            </div>
        </div>
        @endif

        @if(in_array(auth()->user()->role, ['admin', 'manager', 'produksi']))
        <!-- Produksi Tertunda -->
        <div class="rounded-xl border bg-card text-card-foreground shadow-sm">
            <div class="p-4 flex flex-row items-center justify-between space-y-0 pb-2">
                <h3 class="tracking-tight text-sm font-medium">Produksi Tertunda</h3>
                <x-heroicon-o-clock class="h-4 w-4 text-orange-500" />
            </div>
            <div class="p-4 pt-0">
                <div class="text-xl sm:text-2xl font-bold">
                    {{ $produksiTertunda }}
                </div>
                <p class="text-xs text-muted-foreground mt-1">
                    Menunggu dimulai
                </p>
            </div>
        </div>

        <!-- Produksi Sedang Berjalan -->
        <div class="rounded-xl border bg-card text-card-foreground shadow-sm">
            <div class="p-4 flex flex-row items-center justify-between space-y-0 pb-2">
                <h3 class="tracking-tight text-sm font-medium">Produksi Sedang Berjalan</h3>
                <x-heroicon-o-cog class="h-4 w-4 text-blue-500" />
            </div>
            <div class="p-4 pt-0">
                <div class="text-xl sm:text-2xl font-bold">
                    {{ $produksiBerjalan }}
                </div>
                <p class="text-xs text-muted-foreground mt-1">
                    Dalam proses pabrikasi
                </p>
            </div>
        </div>

        <!-- Produksi Selesai -->
        <div class="rounded-xl border bg-card text-card-foreground shadow-sm">
            <div class="p-4 flex flex-row items-center justify-between space-y-0 pb-2">
                <h3 class="tracking-tight text-sm font-medium">Produksi Selesai</h3>
                <x-heroicon-o-check-circle class="h-4 w-4 text-emerald-500" />
            </div>
            <div class="p-4 pt-0">
                <div class="text-xl sm:text-2xl font-bold">
                    {{ $produksiSelesai }}
                </div>
                <p class="text-xs text-muted-foreground mt-1">
                    Periode ini
                </p>
            </div>
        </div>
        @endif

        @if(in_array(auth()->user()->role, ['admin', 'manager', 'gudang']))
         <!-- Low Stock Alert -->
         <div class="rounded-xl border bg-card text-card-foreground shadow-sm">
            <div class="p-4 flex flex-row items-center justify-between space-y-0 pb-2">
                <h3 class="tracking-tight text-sm font-medium">Peringatan Stok Tipis</h3>
                <x-heroicon-o-exclamation-triangle class="h-4 w-4 text-red-500" />
            </div>
            <div class="p-4 pt-0">
                <div class="text-xl sm:text-2xl font-bold">
                    {{ count($lowStockProducts) }}
                </div>
                <p class="text-xs text-muted-foreground mt-1">
                    Barang di bawah stok minimum
                </p>
            </div>
        </div>

        <!-- Total Stok Produk -->
        <div class="rounded-xl border bg-card text-card-foreground shadow-sm">
            <div class="p-4 flex flex-row items-center justify-between space-y-0 pb-2">
                <h3 class="tracking-tight text-sm font-medium">Total Stok Produk</h3>
                <x-heroicon-o-cube class="h-4 w-4 text-indigo-500" />
            </div>
            <div class="p-4 pt-0">
                <div class="text-xl sm:text-2xl font-bold">
                    {{ number_format($totalStokProduk, 0, ',', '.') }}
                </div>
                <p class="text-xs text-muted-foreground mt-1">
                    Barang jadi
                </p>
            </div>
        </div>

        <!-- Total Stok Bahan -->
        <div class="rounded-xl border bg-card text-card-foreground shadow-sm">
            <div class="p-4 flex flex-row items-center justify-between space-y-0 pb-2">
                <h3 class="tracking-tight text-sm font-medium">Stok Bahan Baku</h3>
                <x-heroicon-o-square-3-stack-3d class="h-4 w-4 text-amber-500" />
            </div>
            <div class="p-4 pt-0">
                <div class="text-xl sm:text-2xl font-bold">
                    {{ number_format($totalStokBahan, 0, ',', '.') }}
                </div>
                <p class="text-xs text-muted-foreground mt-1">
                    Material mentah
                </p>
            </div>
        </div>

        <!-- Pergerakan Stok -->
        <div class="rounded-xl border bg-card text-card-foreground shadow-sm">
            <div class="p-4 flex flex-row items-center justify-between space-y-0 pb-2">
                <h3 class="tracking-tight text-sm font-medium">Pergerakan Stok</h3>
                 <x-heroicon-o-arrows-right-left class="h-4 w-4 text-muted-foreground" />
            </div>
            <div class="p-4 pt-0">
                <div class="text-xl sm:text-2xl font-bold">
                    {{ number_format($stokMasuk + $stokKeluar, 0, ',', '.') }}
                </div>
                <div class="flex justify-between text-[11px] sm:text-xs text-muted-foreground mt-1">
                    <span class="text-emerald-600 flex items-center gap-1" title="Barang Masuk">
                        <x-heroicon-s-arrow-down class="w-3 h-3" /> {{ number_format($stokMasuk, 0, ',', '.') }}
                    </span>
                    <span class="text-red-600 flex items-center gap-1" title="Barang Keluar">
                        <x-heroicon-s-arrow-up class="w-3 h-3" /> {{ number_format($stokKeluar, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
        @endif
    </div>

    @if(in_array(auth()->user()->role, ['admin', 'manager']))
    <!-- Charts Section -->
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3 print-grid-2">
        <!-- Sales Trend -->
        <div class="col-span-1 lg:col-span-2 rounded-xl border bg-card text-card-foreground shadow-sm break-inside-avoid print-chart-card">
            <div class="p-4 flex flex-col space-y-1.5 pb-2">
                <h3 class="font-semibold leading-none tracking-tight">Tren Faktur Penjualan</h3>
                <p class="text-xs text-muted-foreground">Performa tagihan harian.</p>
            </div>
            <div class="p-4 pt-0" wire:ignore>
                <div id="salesChart" class="w-full h-[250px]"></div>
            </div>
        </div>

        <!-- Cash Flow -->
        <div class="col-span-1 rounded-xl border bg-card text-card-foreground shadow-sm break-inside-avoid print-chart-card">
            <div class="p-4 flex flex-col space-y-1.5 pb-2">
                <h3 class="font-semibold leading-none tracking-tight">Pemasukan vs Pengeluaran</h3>
                <p class="text-xs text-muted-foreground">Ringkasan finansial.</p>
            </div>
            <div class="p-4 pt-0" wire:ignore>
                <div id="cashFlowChart" class="w-full h-[250px]"></div>
            </div>
        </div>

        <!-- Expense Breakdown -->
        <div class="col-span-1 rounded-xl border bg-card text-card-foreground shadow-sm break-inside-avoid print-chart-card">
            <div class="p-4 flex flex-col space-y-1.5 pb-2">
                <h3 class="font-semibold leading-none tracking-tight">Rincian Pengeluaran</h3>
                <p class="text-xs text-muted-foreground">Distribusi kategori.</p>
            </div>
            <div class="p-4 pt-0" wire:ignore>
                <div id="expenseChart" class="w-full h-[250px] flex items-center justify-center"></div>
            </div>
        </div>
    </div>

    <!-- Data Tables Section -->
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3 print-grid-2">
        <!-- Recent Sales -->
        <div class="col-span-1 lg:col-span-2 rounded-xl border bg-card text-card-foreground shadow-sm break-inside-avoid">
            <div class="p-4 flex flex-col space-y-1.5 border-b">
                <h3 class="font-semibold leading-none tracking-tight">Faktur Terbaru</h3>
                <p class="text-xs text-muted-foreground">Ringkasan transaksi terbaru.</p>
            </div>
            <div class="p-0">
                <div class="relative w-full overflow-auto max-h-[300px] print:max-h-none print:overflow-visible">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b sticky top-0 bg-card z-10">
                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                <th class="h-10 px-4 text-left align-middle font-medium text-muted-foreground">Faktur</th>
                                <th class="h-10 px-4 text-right align-middle font-medium text-muted-foreground">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0 bg-transparent">
                            @forelse($recentSales as $sale)
                                <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                    <td class="px-4 py-2 align-middle font-medium">
                                        {{ $sale['invoice_number'] }}
                                        <div class="text-[11px] text-muted-foreground font-normal">{{ $sale['customer']['name'] ?? 'Guest' }}</div>
                                    </td>
                                    <td class="px-4 py-2 align-middle text-right font-medium text-emerald-600">@money($sale['total'])</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="p-4 text-center text-muted-foreground">Tidak ada faktur terbaru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-2 print-grid-2">
        <!-- Top Selling Products -->
        <div class="col-span-1 rounded-xl border bg-card text-card-foreground shadow-sm break-inside-avoid">
            <div class="p-4 flex flex-col space-y-1.5 border-b">
                <h3 class="font-semibold leading-none tracking-tight">Produk Terlaris</h3>
                <p class="text-xs text-muted-foreground">Barang paling laku.</p>
            </div>
             <div class="p-4 pt-4 max-h-[300px] overflow-auto print:max-h-none print:overflow-visible">
                <div class="space-y-4">
                    @forelse($topProducts as $product)
                        <div class="flex items-center justify-between">
                            <div class="space-y-1 flex-1">
                                <p class="text-sm font-medium leading-none truncate pr-2" title="{{ $product['product_name'] }}">{{ $product['product_name'] }}</p>
                                <p class="text-[11px] text-muted-foreground">{{ $product['sku'] }}</p>
                            </div>
                            <div class="font-semibold text-sm bg-muted px-2 py-1 rounded-md">
                                {{ $product['total_sold'] }} <span class="text-xs font-normal text-muted-foreground">terjual</span>
                            </div>
                        </div>
                    @empty
                         <p class="text-xs text-muted-foreground text-center py-2">Tidak ada data produk.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Top Customers -->
        <div class="col-span-1 rounded-xl border bg-card text-card-foreground shadow-sm break-inside-avoid">
            <div class="p-4 flex flex-col space-y-1.5 border-b">
                <h3 class="font-semibold leading-none tracking-tight">Pelanggan Terbaik</h3>
                <p class="text-xs text-muted-foreground">Berdasarkan pendapatan tertinggi.</p>
            </div>
             <div class="p-4 pt-4 max-h-[300px] overflow-auto print:max-h-none print:overflow-visible">
                <div class="space-y-4">
                    @forelse($topCustomers as $customer)
                        <div class="flex items-center justify-between">
                            <div class="space-y-1 flex-1">
                                <p class="text-sm font-medium leading-none truncate pr-2" title="{{ $customer['customer_name'] }}">{{ $customer['customer_name'] }}</p>
                                <p class="text-[11px] text-muted-foreground">{{ $customer['phone'] }}</p>
                            </div>
                            <div class="font-semibold text-sm text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md whitespace-nowrap">
                                @money($customer['total_spent'])
                            </div>
                        </div>
                    @empty
                         <p class="text-xs text-muted-foreground text-center py-2">Tidak ada data pelanggan.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
    @media print {
        @page { margin: 1cm; }
        body { -webkit-print-color-adjust: exact; print-color-adjust: exact; background-color: white !important; }
        
        /* Memastikan halaman tidak terpotong (Unlock the height constraints) */
        html, body, main, .min-h-screen, .h-screen, .h-full, .overflow-hidden, .overflow-y-auto { 
            height: auto !important; 
            overflow: visible !important; 
        }
        main, div {
             overflow: visible !important;
        }

        .print\:hidden { display: none !important; }
        .bg-card { border: 1px solid #e2e8f0; }
        
        /* Grid Khusus 2 Kolom (Untuk Stats & Tables) */
        .print-grid-2 { 
            display: grid !important;
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important; 
            gap: 0.5rem !important; 
        }
        .print-grid-2 > .lg\:col-span-2 { 
            grid-column: span 2 / span 2 !important; 
        }

        /* Grid Khusus 1 Kolom (Untuk elemen yang butuh full width mutlak) */
        .print-grid-1 { 
            display: grid !important;
            grid-template-columns: repeat(1, minmax(0, 1fr)) !important; 
            gap: 1rem !important; 
        }
        .print-grid-1 > div {
            grid-column: span 1 / span 1 !important;
        }

        /* Paksa grafik ApexCharts agar TIDAK luber/keluar ke sebelah kanan kotak saat dicetak */
        .apexcharts-canvas,
        .apexcharts-canvas svg,
        .apexcharts-canvas foreignObject {
            max-width: 100% !important;
            width: 100% !important;
        }

        .print-chart-card {
            padding-bottom: 1.5rem !important;
        }

        /* Prevent charts and cards from breaking across pages */
        .break-inside-avoid { break-inside: avoid; page-break-inside: avoid; }
        
        /* Matikan fungsi scrollbar di tabel agar semua baris tercetak utuh */
        .overflow-auto { max-height: none !important; overflow: visible !important; }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        let salesChart = null;
        let cashFlowChart = null;
        
        const currencySymbol = "{{ \App\Models\Setting::get('currency_symbol', 'Rp') }}";
        const currencyPosition = "{{ \App\Models\Setting::get('currency_position', 'left') }}";

        const formatMoney = (val) => {
            let num = new Intl.NumberFormat('id-ID', { minimumFractionDigits: 0 }).format(val);
            return currencyPosition === 'left' ? currencySymbol + ' ' + num : num + ' ' + currencySymbol;
        };

        const initCharts = (data) => {
            // Sales Chart
            const salesOptions = {
                series: [{
                    name: 'Sales',
                    data: data.sales.data
                }],
                chart: {
                    type: 'area',
                    height: 250,
                    toolbar: { show: false },
                    fontFamily: 'inherit',
                    parentHeightOffset: 0
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 2 },
                xaxis: {
                    categories: data.sales.labels,
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: {
                        style: { cssClass: 'text-[10px] text-muted-foreground' }
                    }
                },
                yaxis: {
                    labels: {
                        style: { cssClass: 'text-[10px] text-muted-foreground' }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                             return formatMoney(val);
                        }
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.2,
                        stops: [0, 90, 100]
                    }
                },
                colors: ['#0ea5e9'], // Sky 500
                tooltip: {
                    y: {
                        formatter: function (val) {
                             return formatMoney(val);
                        }
                    }
                }
            };

            // Cash Flow Chart
            const cashFlowOptions = {
                series: [{
                    name: 'Income',
                    data: data.cashFlow.income
                }, {
                    name: 'Expense',
                    data: data.cashFlow.expense
                }],
                chart: {
                    type: 'bar',
                    height: 250,
                    toolbar: { show: false },
                    fontFamily: 'inherit',
                    parentHeightOffset: 0
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: { enabled: false },
                stroke: { show: true, width: 2, colors: ['transparent'] },
                xaxis: {
                    categories: data.cashFlow.labels,
                    labels: {
                        style: { cssClass: 'text-[10px] text-muted-foreground' }
                    }
                },
                yaxis: {
                    labels: {
                        style: { cssClass: 'text-[10px] text-muted-foreground' },
                        formatter: (val) => {
                             // Shorten detailed numbers for y-axis
                             if (val >= 1000000) return (val / 1000000).toFixed(1) + 'M';
                             if (val >= 1000) return (val / 1000).toFixed(0) + 'k';
                             return val;
                        }
                    }
                },
                colors: ['#10b981', '#ef4444'], // Emerald 500, Red 500
                fill: { opacity: 1 },
                tooltip: {
                    y: {
                        formatter: function (val) {
                             return formatMoney(val);
                        }
                    }
                }
            };

            // Expense Breakdown Chart
            const hasExpenseData = data.expense.series && data.expense.series.length > 0;
            const expenseOptions = {
                series: hasExpenseData ? data.expense.series.map(Number) : [1],
                labels: hasExpenseData ? data.expense.labels : ['No Data'],
                chart: {
                    type: 'donut',
                    height: 250,
                    fontFamily: 'inherit',
                    parentHeightOffset: 0
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%'
                        }
                    }
                },
                dataLabels: { enabled: false },
                colors: hasExpenseData ? ['#ef4444', '#f97316', '#f59e0b', '#84cc16', '#06b6d4', '#6366f1'] : ['#e5e7eb'],
                tooltip: {
                    enabled: hasExpenseData,
                    y: {
                        formatter: function (val) {
                             return formatMoney(val);
                        }
                    }
                },
                legend: {
                    position: 'bottom',
                    offsetY: 0,
                    height: 60,
                }
            };

            if (salesChart) salesChart.destroy();
            if (cashFlowChart) cashFlowChart.destroy();
            if (window.expenseChartInst) window.expenseChartInst.destroy();

            let salesEl = document.querySelector("#salesChart");
            if (salesEl) {
                salesChart = new ApexCharts(salesEl, salesOptions);
                salesChart.render();
            }

            let cashFlowEl = document.querySelector("#cashFlowChart");
            if (cashFlowEl) {
                cashFlowChart = new ApexCharts(cashFlowEl, cashFlowOptions);
                cashFlowChart.render();
            }
            
            let expenseEl = document.querySelector("#expenseChart");
            if (expenseEl) {
                window.expenseChartInst = new ApexCharts(expenseEl, expenseOptions);
                window.expenseChartInst.render();
            }
        };

        // Initial Load
        initCharts({
            sales: @json($salesChart),
            cashFlow: @json($cashFlowChart),
            expense: @json($expenseChart)
        });



        // Listen for server-side updates
        Livewire.on('stats-updated', (data) => {
             initCharts(data[0]); // data is array of args
        });
    });
</script>
</div>
