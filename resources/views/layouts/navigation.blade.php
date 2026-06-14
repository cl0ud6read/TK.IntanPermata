<!-- Mobile Sidebar Backdrop -->
<div x-show="sidebarOpen" 
     class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden"
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click="sidebarOpen = false" style="display: none;"></div>

<!-- Sidebar -->
<aside class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-slate-200 shadow-[4px_0_24px_rgba(0,0,0,0.02)] lg:static lg:flex lg:flex-col transition-transform duration-300 ease-in-out shrink-0 print:hidden"
       :class="{'translate-x-0': sidebarOpen, '-translate-x-full lg:translate-x-0': !sidebarOpen}">
    
    <!-- Sidebar Header (Logo) -->
    <div class="flex items-center justify-between h-16 px-6 border-b border-slate-100 shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/logo_circle.png') }}" class="w-9 h-9 object-contain rounded-full border border-indigo-100 shadow-sm" alt="Logo" />
            <span class="text-xl font-extrabold tracking-tight text-slate-800">
                TK.IntanPermata
            </span>
        </a>
        <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-slate-600 focus:outline-none">
            <x-heroicon-o-x-mark class="w-6 h-6" />
        </button>
    </div>

    <!-- Sidebar Menu Scrollable Area -->
    <div class="flex-1 overflow-y-auto px-4 py-6 custom-scrollbar">
        <nav class="space-y-1.5 flex flex-col gap-1">
            
            <!-- Beranda -->
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-all duration-200 {{ request()->routeIs(['dashboard', 'role.dashboard']) ? 'bg-indigo-50 text-indigo-700 shadow-sm border border-indigo-100/50' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border border-transparent' }}">
                <x-heroicon-o-squares-2x2 class="w-5 h-5 {{ request()->routeIs(['dashboard', 'role.dashboard']) ? 'text-indigo-600' : 'text-slate-400' }}" />
                Beranda
            </a>

            @if(auth()->user()->role === 'admin')
                <!-- Penjualan Accordion -->
                <div x-data="{ expanded: {{ request()->routeIs(['sales.*', 'customers.*']) ? 'true' : 'false' }} }" class="pt-1">
                    <button @click="expanded = !expanded" class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg font-medium transition-all duration-200 {{ request()->routeIs(['sales.*', 'customers.*']) ? 'text-indigo-700 bg-indigo-50/50 border border-indigo-100/30' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border border-transparent' }}">
                        <div class="flex items-center gap-3">
                            <x-heroicon-o-shopping-bag class="w-5 h-5 {{ request()->routeIs(['sales.*', 'customers.*']) ? 'text-indigo-600' : 'text-slate-400' }}" />
                            Penjualan
                        </div>
                        <x-heroicon-o-chevron-down class="w-4 h-4 transition-transform duration-200" x-bind:class="expanded ? 'rotate-180' : ''" />
                    </button>
                    <div x-show="expanded" x-collapse class="pl-11 pr-2 pt-1 pb-2 space-y-1">
                        <a href="{{ route('sales.index') }}" class="block px-3 py-2 text-sm rounded-md font-medium transition-colors {{ request()->routeIs(['sales.index', 'sales.show']) ? 'text-indigo-600 bg-white shadow-sm border border-slate-100' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">Daftar Penjualan</a>
                        <a href="{{ route('customers.index') }}" class="block px-3 py-2 text-sm rounded-md font-medium transition-colors {{ request()->routeIs('customers.*') ? 'text-indigo-600 bg-white shadow-sm border border-slate-100' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">Pelanggan</a>
                    </div>
                </div>
            @endif

            @if(auth()->user()->role === 'admin')
                <!-- Pembelian Accordion -->
                <div x-data="{ expanded: {{ request()->routeIs(['purchases.*', 'suppliers.*']) ? 'true' : 'false' }} }">
                    <button @click="expanded = !expanded" class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg font-medium transition-all duration-200 {{ request()->routeIs(['purchases.*', 'suppliers.*']) ? 'text-indigo-700 bg-indigo-50/50 border border-indigo-100/30' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border border-transparent' }}">
                        <div class="flex items-center gap-3">
                            <x-heroicon-o-truck class="w-5 h-5 {{ request()->routeIs(['purchases.*', 'suppliers.*']) ? 'text-indigo-600' : 'text-slate-400' }}" />
                            Pembelian
                        </div>
                        <x-heroicon-o-chevron-down class="w-4 h-4 transition-transform duration-200" x-bind:class="expanded ? 'rotate-180' : ''" />
                    </button>
                    <div x-show="expanded" x-collapse class="pl-11 pr-2 pt-1 pb-2 space-y-1">
                        <a href="{{ route('purchases.index') }}" class="block px-3 py-2 text-sm rounded-md font-medium transition-colors {{ request()->routeIs('purchases.*') ? 'text-indigo-600 bg-white shadow-sm border border-slate-100' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">Daftar Pembelian</a>
                        <a href="{{ route('suppliers.index') }}" class="block px-3 py-2 text-sm rounded-md font-medium transition-colors {{ request()->routeIs('suppliers.*') ? 'text-indigo-600 bg-white shadow-sm border border-slate-100' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">Pemasok</a>
                    </div>
                </div>
            @endif

            @if(auth()->user()->role === 'admin')
                <!-- Keuangan Accordion -->
                <div x-data="{ expanded: {{ request()->routeIs(['finance.*']) ? 'true' : 'false' }} }">
                    <button @click="expanded = !expanded" class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg font-medium transition-all duration-200 {{ request()->routeIs(['finance.*']) ? 'text-indigo-700 bg-indigo-50/50 border border-indigo-100/30' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border border-transparent' }}">
                        <div class="flex items-center gap-3">
                            <x-heroicon-o-banknotes class="w-5 h-5 {{ request()->routeIs(['finance.*']) ? 'text-indigo-600' : 'text-slate-400' }}" />
                            Keuangan
                        </div>
                        <x-heroicon-o-chevron-down class="w-4 h-4 transition-transform duration-200" x-bind:class="expanded ? 'rotate-180' : ''" />
                    </button>
                    <div x-show="expanded" x-collapse class="pl-11 pr-2 pt-1 pb-2 space-y-1">
                        <a href="{{ route('finance.transactions.index') }}" class="block px-3 py-2 text-sm rounded-md font-medium transition-colors {{ request()->routeIs('finance.transactions.index') ? 'text-indigo-600 bg-white shadow-sm border border-slate-100' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">Transaksi</a>
                        <a href="{{ route('finance.categories.index') }}" class="block px-3 py-2 text-sm rounded-md font-medium transition-colors {{ request()->routeIs('finance.categories.index') ? 'text-indigo-600 bg-white shadow-sm border border-slate-100' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">Kategori</a>
                    </div>
                </div>
            @endif

                <!-- Laporan Manager -->
                @if(auth()->user()->role === 'manager')
                <div class="pt-4 border-t border-slate-100 mt-2">
                    <div class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Laporan (Manager)</div>
                    
                    <!-- Laporan Produksi -->
                    <a href="{{ route('produksi.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-all duration-200 {{ request()->fullUrlIs(route('produksi.index')) ? 'bg-indigo-50 text-indigo-700 shadow-sm border border-indigo-100/50' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border border-transparent' }}">
                        <x-heroicon-o-document-text class="w-5 h-5 {{ request()->fullUrlIs(route('produksi.index')) ? 'text-indigo-600' : 'text-slate-400' }}" />
                        Laporan Produksi
                    </a>

                    <!-- Laporan Persediaan -->
                    <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-all duration-200 {{ request()->fullUrlIs(route('products.index')) ? 'bg-indigo-50 text-indigo-700 shadow-sm border border-indigo-100/50' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border border-transparent' }}">
                        <x-heroicon-o-clipboard-document-list class="w-5 h-5 {{ request()->fullUrlIs(route('products.index')) ? 'text-indigo-600' : 'text-slate-400' }}" />
                        Laporan Persediaan
                    </a>

                    <!-- Laporan Penjualan -->
                    <a href="{{ route('sales.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-all duration-200 {{ request()->fullUrlIs(route('sales.index')) ? 'bg-indigo-50 text-indigo-700 shadow-sm border border-indigo-100/50' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border border-transparent' }}">
                        <x-heroicon-o-shopping-bag class="w-5 h-5 {{ request()->fullUrlIs(route('sales.index')) ? 'text-indigo-600' : 'text-slate-400' }}" />
                        Laporan Penjualan
                    </a>

                    <!-- Laporan Pembelian -->
                    <a href="{{ route('purchases.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-all duration-200 {{ request()->fullUrlIs(route('purchases.index')) ? 'bg-indigo-50 text-indigo-700 shadow-sm border border-indigo-100/50' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border border-transparent' }}">
                        <x-heroicon-o-truck class="w-5 h-5 {{ request()->fullUrlIs(route('purchases.index')) ? 'text-indigo-600' : 'text-slate-400' }}" />
                        Laporan Pembelian
                    </a>

                    <!-- Laporan Keuangan -->
                    <a href="{{ route('finance.transactions.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-all duration-200 {{ request()->fullUrlIs(route('finance.transactions.index')) ? 'bg-indigo-50 text-indigo-700 shadow-sm border border-indigo-100/50' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border border-transparent' }}">
                        <x-heroicon-o-banknotes class="w-5 h-5 {{ request()->fullUrlIs(route('finance.transactions.index')) ? 'text-indigo-600' : 'text-slate-400' }}" />
                        Laporan Keuangan
                    </a>
                </div>
                @endif



            @if(in_array(auth()->user()->role, ['admin', 'gudang', 'produksi']))
                <!-- Data Master Accordion -->
                <div x-data="{ expanded: {{ request()->routeIs(['products.*', 'categories.*', 'units.*', 'bahan-baku.*', 'bom.*']) ? 'true' : 'false' }} }">
                    <button @click="expanded = !expanded" class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg font-medium transition-all duration-200 {{ request()->routeIs(['products.*', 'categories.*', 'units.*', 'bahan-baku.*', 'bom.*']) ? 'text-indigo-700 bg-indigo-50/50 border border-indigo-100/30' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border border-transparent' }}">
                        <div class="flex items-center gap-3">
                            <x-heroicon-o-cube class="w-5 h-5 {{ request()->routeIs(['products.*', 'categories.*', 'units.*', 'bahan-baku.*', 'bom.*']) ? 'text-indigo-600' : 'text-slate-400' }}" />
                            Data Master
                        </div>
                        <x-heroicon-o-chevron-down class="w-4 h-4 transition-transform duration-200" x-bind:class="expanded ? 'rotate-180' : ''" />
                    </button>
                    <div x-show="expanded" x-collapse class="pl-11 pr-2 pt-1 pb-2 space-y-1">
                        @if(in_array(auth()->user()->role, ['admin', 'gudang']))
                        <a href="{{ route('products.index') }}" class="block px-3 py-2 text-sm rounded-md font-medium transition-colors {{ request()->routeIs('products.*') ? 'text-indigo-600 bg-white shadow-sm border border-slate-100' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">Produk</a>
                        @endif
                        @if(auth()->user()->role === 'admin')
                        <a href="{{ route('categories.index') }}" class="block px-3 py-2 text-sm rounded-md font-medium transition-colors {{ request()->routeIs('categories.*') ? 'text-indigo-600 bg-white shadow-sm border border-slate-100' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">Kategori Produk</a>
                        <a href="{{ route('units.index') }}" class="block px-3 py-2 text-sm rounded-md font-medium transition-colors {{ request()->routeIs('units.*') ? 'text-indigo-600 bg-white shadow-sm border border-slate-100' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">Satuan</a>
                        @endif
                        @if(in_array(auth()->user()->role, ['admin', 'gudang']))
                        <a href="{{ route('bahan-baku.index') }}" class="block px-3 py-2 text-sm rounded-md font-medium transition-colors {{ request()->routeIs('bahan-baku.*') ? 'text-indigo-600 bg-white shadow-sm border border-slate-100' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">Bahan Baku</a>
                        @endif
                        @if(auth()->user()->role === 'produksi')
                        <a href="{{ route('bom.index') }}" class="block px-3 py-2 text-sm rounded-md font-medium transition-colors {{ request()->routeIs('bom.*') ? 'text-indigo-600 bg-white shadow-sm border border-slate-100' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">Resep (BOM)</a>
                        @endif
                    </div>
                </div>
            @endif

            @if(in_array(auth()->user()->role, ['produksi']))
                <!-- Manajemen Produksi Accordion -->
                <div x-data="{ expanded: {{ request()->routeIs(['produksi.*']) ? 'true' : 'false' }} }">
                    <button @click="expanded = !expanded" class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg font-medium transition-all duration-200 {{ request()->routeIs(['produksi.*']) ? 'text-indigo-700 bg-indigo-50/50 border border-indigo-100/30' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border border-transparent' }}">
                        <div class="flex items-center gap-3">
                            <x-heroicon-o-cog-8-tooth class="w-5 h-5 {{ request()->routeIs(['produksi.*']) ? 'text-indigo-600' : 'text-slate-400' }}" />
                            Manajemen Produksi
                        </div>
                        <x-heroicon-o-chevron-down class="w-4 h-4 transition-transform duration-200" x-bind:class="expanded ? 'rotate-180' : ''" />
                    </button>
                    <div x-show="expanded" x-collapse class="pl-11 pr-2 pt-1 pb-2 space-y-1">
                        <a href="{{ route('produksi.create') }}" class="block px-3 py-2 text-sm rounded-md font-medium transition-colors {{ request()->routeIs('produksi.create') ? 'text-indigo-600 bg-white shadow-sm border border-slate-100' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">Pencatatan Produksi</a>
                        <a href="{{ route('produksi.index') }}" class="block px-3 py-2 text-sm rounded-md font-medium transition-colors {{ request()->routeIs(['produksi.index', 'produksi.show', 'produksi.edit']) ? 'text-indigo-600 bg-white shadow-sm border border-slate-100' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">Pemantauan Produksi</a>
                    </div>
                </div>
            @endif

            @if(in_array(auth()->user()->role, ['admin', 'gudang']))
                <!-- Gudang Accordion -->
                <div x-data="{ expanded: {{ request()->routeIs(['gudang.*']) ? 'true' : 'false' }} }">
                    <button @click="expanded = !expanded" class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg font-medium transition-all duration-200 {{ request()->routeIs(['gudang.*']) ? 'text-indigo-700 bg-indigo-50/50 border border-indigo-100/30' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border border-transparent' }}">
                        <div class="flex items-center gap-3">
                            <x-heroicon-o-home-modern class="w-5 h-5 {{ request()->routeIs(['gudang.*']) ? 'text-indigo-600' : 'text-slate-400' }}" />
                            Gudang
                        </div>
                        <x-heroicon-o-chevron-down class="w-4 h-4 transition-transform duration-200" x-bind:class="expanded ? 'rotate-180' : ''" />
                    </button>
                    <div x-show="expanded" x-collapse class="pl-11 pr-2 pt-1 pb-2 space-y-1">
                        <a href="{{ route('gudang.masuk.purchase') }}" class="block px-3 py-2 text-sm rounded-md font-medium transition-colors {{ request()->routeIs('gudang.masuk.purchase') ? 'text-indigo-600 bg-white shadow-sm border border-slate-100' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">Masuk (Pembelian)</a>
                        <a href="{{ route('gudang.masuk.produksi') }}" class="block px-3 py-2 text-sm rounded-md font-medium transition-colors {{ request()->routeIs('gudang.masuk.produksi') ? 'text-indigo-600 bg-white shadow-sm border border-slate-100' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">Masuk (Produksi)</a>
                        <a href="{{ route('gudang.keluar.produksi') }}" class="block px-3 py-2 text-sm rounded-md font-medium transition-colors {{ request()->routeIs('gudang.keluar.produksi') ? 'text-indigo-600 bg-white shadow-sm border border-slate-100' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">Keluar (Bahan Baku)</a>
                        <a href="{{ route('gudang.keluar.sale') }}" class="block px-3 py-2 text-sm rounded-md font-medium transition-colors {{ request()->routeIs('gudang.keluar.sale') ? 'text-indigo-600 bg-white shadow-sm border border-slate-100' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">Keluar (Penjualan)</a>
                        <a href="{{ route('gudang.adjustment.create') }}" class="block px-3 py-2 text-sm rounded-md font-medium transition-colors {{ request()->routeIs('gudang.adjustment.*') ? 'text-indigo-600 bg-white shadow-sm border border-slate-100' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">Penyesuaian Stok</a>
                    </div>
                </div>
            @endif

            <!-- Spacer -->
            <div class="h-4"></div>

            @if(auth()->user()->role === 'admin')
                <div class="pt-4 border-t border-slate-100 mt-2">
                    <div class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Administrasi</div>
                    <!-- Pengguna -->
                    <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-indigo-50 text-indigo-700 shadow-sm border border-indigo-100/50' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border border-transparent' }}">
                        <x-heroicon-o-users class="w-5 h-5 {{ request()->routeIs('users.*') ? 'text-indigo-600' : 'text-slate-400' }}" />
                        Pengguna
                    </a>
                </div>
            @endif
        </nav>
    </div>

</aside>

<!-- Scrollbar style specific for sidebar -->
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 20px;
    }
    .custom-scrollbar:hover::-webkit-scrollbar-thumb {
        background-color: #94a3b8;
    }
</style>
