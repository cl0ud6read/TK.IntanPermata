<section class="py-4 bg-background border-b border-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ mobileMenuOpen: false }">
        <!-- Desktop Menu -->
        <nav class="hidden items-center justify-between lg:flex gap-2 xl:gap-4">
            <div class="flex items-center gap-2 xl:gap-6">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" class="w-10 h-10 shrink-0 object-cover rounded-full" alt="Logo" />
                    <span class="text-xl font-extrabold tracking-tighter text-gray-900 whitespace-nowrap">
                        TK.IntanPermata
                    </span>
                </a>

                <!-- Navigation Menu -->
                <div class="flex flex-col gap-2 w-full justify-center ml-4">
                    <div class="flex flex-row flex-wrap items-center gap-2">
                        <!-- Dashboard Link -->
                        <a href="{{ route('dashboard') }}" class="group inline-flex h-10 w-max items-center justify-center rounded-md px-3 py-2 text-sm font-medium transition-colors hover:bg-muted hover:text-accent-foreground disabled:pointer-events-none disabled:opacity-50 {{ request()->routeIs('dashboard') ? 'bg-accent/50 text-accent-foreground' : 'bg-background' }}">
                            <x-heroicon-o-squares-2x2 class="mr-2 h-4 w-4 shrink-0" />
                            Dashboard
                        </a>

                        @if(in_array(auth()->user()->role, ['admin', 'manager']))
                            <!-- Sales Dropdown -->
                            <x-nav-dropdown active="{{ request()->routeIs(['sales.*', 'customers.*']) }}">
                                <x-slot name="icon">
                                    <x-heroicon-o-banknotes class="mr-2 h-4 w-4 shrink-0" />
                                </x-slot>
                                <x-slot name="trigger">
                                    {{ request()->routeIs('sales.create') ? 'POS' : (request()->routeIs(['sales.index', 'sales.show']) ? 'Sales' : (request()->routeIs('customers.*') ? 'Customers' : 'Sales Menu')) }}
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('sales.create')" :active="request()->routeIs('sales.create')">
                                        POS
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('sales.index')" :active="request()->routeIs(['sales.index', 'sales.show'])">
                                        Sales
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('customers.index')" :active="request()->routeIs('customers.*')">
                                        Customers
                                    </x-dropdown-link>
                                </x-slot>
                            </x-nav-dropdown>
                        @endif

                        @if(in_array(auth()->user()->role, ['admin', 'manager']))
                            <!-- Purchases Dropdown -->
                            <x-nav-dropdown active="{{ request()->routeIs(['purchases.*', 'suppliers.*']) }}">
                                <x-slot name="icon">
                                    <x-heroicon-o-shopping-cart class="mr-2 h-4 w-4 shrink-0" />
                                </x-slot>
                                <x-slot name="trigger">
                                    {{ request()->routeIs('purchases.*') ? 'Purchases' : (request()->routeIs('suppliers.*') ? 'Suppliers' : 'Purchases Menu') }}
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('purchases.index')" :active="request()->routeIs('purchases.*')">
                                        Purchases
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('suppliers.index')" :active="request()->routeIs('suppliers.*')">
                                        Suppliers
                                    </x-dropdown-link>
                                </x-slot>
                            </x-nav-dropdown>
                        @endif

                        @if(in_array(auth()->user()->role, ['admin', 'manager']))
                            <!-- Finance Dropdown -->
                            <x-nav-dropdown active="{{ request()->routeIs(['finance.*']) }}">
                                <x-slot name="icon">
                                    <x-heroicon-o-currency-dollar class="mr-2 h-4 w-4 shrink-0" />
                                </x-slot>
                                <x-slot name="trigger">
                                    {{ request()->routeIs('finance.transactions.*') ? 'Transactions' : (request()->routeIs('finance.categories.*') ? 'Categories' : 'Finance') }}
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('finance.transactions.index')" :active="request()->routeIs('finance.transactions.index')">
                                        Transactions
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('finance.categories.index')" :active="request()->routeIs('finance.categories.index')">
                                        Categories
                                    </x-dropdown-link>
                                </x-slot>
                            </x-nav-dropdown>
                        @endif

                    @if(in_array(auth()->user()->role, ['admin', 'manager']))
                    </div>
                    <!-- Bottom Row -->
                    <div class="flex flex-row flex-wrap items-center gap-2">
                    @endif

                        @if(auth()->user()->role === 'admin')
                            <!-- Users Link -->
                            <a href="{{ route('users.index') }}" class="group inline-flex h-10 w-max items-center justify-center rounded-md px-3 py-2 text-sm font-medium transition-colors hover:bg-muted hover:text-accent-foreground disabled:pointer-events-none disabled:opacity-50 {{ request()->routeIs('users.*') ? 'bg-accent/50 text-accent-foreground' : 'bg-background' }}">
                                <x-heroicon-o-users class="mr-2 h-4 w-4 shrink-0" />
                                Users
                            </a>
                        @endif

                        @if(in_array(auth()->user()->role, ['admin', 'manager', 'gudang']))
                            <!-- Products Dropdown -->
                            <x-nav-dropdown active="{{ request()->routeIs(['products.*', 'categories.*', 'units.*', 'bahan-baku.*', 'bom.*']) }}">
                                <x-slot name="icon">
                                    <x-heroicon-o-cube class="mr-2 h-4 w-4 shrink-0" />
                                </x-slot>
                                <x-slot name="trigger">
                                    {{ request()->routeIs('products.*') ? 'Products' : (request()->routeIs('categories.*') ? 'Categories' : (request()->routeIs('units.*') ? 'Units' : (request()->routeIs('bahan-baku.*') ? 'Bahan Baku' : (request()->routeIs('bom.*') ? 'BOM' : 'Master Data')))) }}
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                                        Products
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                                        Categories
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('units.index')" :active="request()->routeIs('units.*')">
                                        Units
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('bahan-baku.index')" :active="request()->routeIs('bahan-baku.*')">
                                        Bahan Baku
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('bom.index')" :active="request()->routeIs('bom.*')">
                                        BOM
                                    </x-dropdown-link>
                                </x-slot>
                            </x-nav-dropdown>
                        @endif

                        @if(in_array(auth()->user()->role, ['admin', 'manager', 'produksi']))
                            <!-- Produksi Link -->
                            <a href="{{ route('produksi.index') }}" class="group inline-flex h-10 w-max items-center justify-center rounded-md px-3 py-2 text-sm font-medium transition-colors hover:bg-muted hover:text-accent-foreground disabled:pointer-events-none disabled:opacity-50 {{ request()->routeIs('produksi.*') ? 'bg-accent/50 text-accent-foreground' : 'bg-background' }}">
                                <x-heroicon-o-cog-8-tooth class="mr-2 h-4 w-4 shrink-0" />
                                Produksi
                            </a>
                        @endif

                        @if(in_array(auth()->user()->role, ['admin', 'manager', 'gudang']))
                            <!-- Gudang Dropdown -->
                            <x-nav-dropdown active="{{ request()->routeIs(['gudang.*']) }}">
                                <x-slot name="icon">
                                    <x-heroicon-o-home-modern class="mr-2 h-4 w-4 shrink-0" />
                                </x-slot>
                                <x-slot name="trigger">
                                    {{ request()->routeIs('gudang.masuk.purchase') ? 'In-PO' : (request()->routeIs('gudang.masuk.produksi') ? 'In-Prod' : (request()->routeIs('gudang.keluar.produksi') ? 'Out-Prod' : (request()->routeIs('gudang.keluar.sale') ? 'Out-Sale' : (request()->routeIs('gudang.adjustment.*') ? 'Adjustment' : 'Gudang')))) }}
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('gudang.masuk.purchase')" :active="request()->routeIs('gudang.masuk.purchase')">
                                        In - Supplier PO
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('gudang.masuk.produksi')" :active="request()->routeIs('gudang.masuk.produksi')">
                                        In - Hasil Produksi
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('gudang.keluar.produksi')" :active="request()->routeIs('gudang.keluar.produksi')">
                                        Out - Ke Produksi
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('gudang.keluar.sale')" :active="request()->routeIs('gudang.keluar.sale')">
                                        Out - Ke Sales
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('gudang.adjustment.create')" :active="request()->routeIs('gudang.adjustment.*')">
                                        Stock Adjustment
                                    </x-dropdown-link>
                                </x-slot>
                            </x-nav-dropdown>
                        @endif
                    </div>
                </div>
            </div>

            <!-- User Auth Buttons -->
            <div class="flex gap-2">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center justify-center whitespace-nowrap rounded-full text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 gap-2">
                            <span class="hidden md:inline-flex">{{ Auth::user()->name }}</span>
                            <x-avatar :name="Auth::user()->name" />
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.index')" :active="request()->routeIs('profile.*')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        @if(auth()->user()->role === 'admin')
                        <x-dropdown-link :href="route('settings.index')" :active="request()->routeIs('settings.*')">
                            {{ __('Settings') }}
                        </x-dropdown-link>
                        @endif

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div class="block lg:hidden">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" class="w-10 h-10 object-cover rounded-full" alt="Logo" />
                </a>

                <button @click="mobileMenuOpen = true" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 w-10">
                    <x-heroicon-o-bars-3 class="h-4 w-4" />
                </button>
            </div>

            <!-- Mobile Sheet/Drawer -->
            <div x-show="mobileMenuOpen"
                x-transition:enter="duration-300 ease-out"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="duration-200 ease-in"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 bg-background/80 backdrop-blur-sm"
                style="display: none;"
                @click="mobileMenuOpen = false">
            </div>

            <div x-show="mobileMenuOpen"
                x-transition:enter="duration-500 ease-in-out"
                x-transition:enter-start="translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="duration-500 ease-in-out"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
                class="fixed inset-y-0 right-0 z-50 h-full w-3/4 gap-4 border-l bg-background p-6 shadow-lg sm:max-w-sm"
                style="display: none;"
                @click.stop>

                <div class="flex flex-col gap-6">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                            <img src="{{ asset('images/logo.png') }}" class="w-10 h-10 shrink-0 object-cover rounded-full" alt="Logo" />
                            <span class="text-xl font-extrabold text-gray-900 whitespace-nowrap">TK.IntanPermata</span>
                        </a>
                        <button @click="mobileMenuOpen = false" class="rounded-sm opacity-70 ring-offset-background transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                            <span class="sr-only">Close</span>
                            <x-heroicon-o-x-mark class="h-4 w-4" />
                        </button>
                    </div>

                    <div class="flex w-full flex-col gap-4">
                        <a href="{{ route('dashboard') }}" class="text-md font-semibold hover:underline {{ request()->routeIs('dashboard') ? 'text-primary' : '' }}">Dashboard</a>

                        @if(in_array(auth()->user()->role, ['admin', 'manager']))
                            <!-- Mobile Sales Accordion -->
                            <div x-data="{ expanded: {{ request()->routeIs(['sales.*', 'customers.*']) ? 'true' : 'false' }} }" class="border-b-0">
                                <button @click="expanded = !expanded" class="flex flex-1 items-center justify-between py-0 font-semibold transition-all hover:underline [&[data-state=open]>svg]:rotate-180 w-full text-left text-md {{ request()->routeIs(['sales.*', 'customers.*']) ? 'text-primary' : '' }}">
                                    {{ request()->routeIs('sales.create') ? 'POS' : (request()->routeIs(['sales.index', 'sales.show']) ? 'Sales' : (request()->routeIs('customers.*') ? 'Customers' : 'Sales Menu')) }}
                                    <x-heroicon-o-chevron-down :class="{'rotate-180': expanded}" class="h-4 w-4 shrink-0 transition-transform duration-200" />
                                </button>
                                <div x-show="expanded" x-collapse>
                                    <div class="mt-2 flex flex-col gap-2 pl-4 border-l border-border ml-2">
                                        <a class="text-sm font-medium hover:underline py-1 {{ request()->routeIs(['sales.index', 'sales.show']) ? 'text-primary' : '' }}" href="{{ route('sales.index') }}">Sales</a>
                                        <a class="text-sm font-medium hover:underline py-1 {{ request()->routeIs('sales.create') ? 'text-primary' : '' }}" href="{{ route('sales.create') }}">POS</a>
                                        <a class="text-sm font-medium hover:underline py-1 {{ request()->routeIs('customers.index') ? 'text-primary' : '' }}" href="{{ route('customers.index') }}">Customers</a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(in_array(auth()->user()->role, ['admin', 'manager']))
                            <!-- Mobile Purchases Accordion -->
                            <div x-data="{ expanded: {{ request()->routeIs(['purchases.*', 'suppliers.*']) ? 'true' : 'false' }} }" class="border-b-0">
                                <button @click="expanded = !expanded" class="flex flex-1 items-center justify-between py-0 font-semibold transition-all hover:underline [&[data-state=open]>svg]:rotate-180 w-full text-left text-md {{ request()->routeIs(['purchases.*', 'suppliers.*']) ? 'text-primary' : '' }}">
                                    {{ request()->routeIs('purchases.*') ? 'Purchases' : (request()->routeIs('suppliers.*') ? 'Suppliers' : 'Purchases Menu') }}
                                    <x-heroicon-o-chevron-down :class="{'rotate-180': expanded}" class="h-4 w-4 shrink-0 transition-transform duration-200" />
                                </button>
                                <div x-show="expanded" x-collapse>
                                    <div class="mt-2 flex flex-col gap-2 pl-4 border-l border-border ml-2">
                                        <a class="text-sm font-medium hover:underline py-1 {{ request()->routeIs('purchases.index') ? 'text-primary' : '' }}" href="{{ route('purchases.index') }}">Purchases</a>
                                        <a class="text-sm font-medium hover:underline py-1 {{ request()->routeIs('suppliers.index') ? 'text-primary' : '' }}" href="{{ route('suppliers.index') }}">Suppliers</a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(in_array(auth()->user()->role, ['admin', 'manager']))
                            <!-- Mobile Finance Accordion -->
                            <div x-data="{ expanded: {{ request()->routeIs(['finance.*']) ? 'true' : 'false' }} }" class="border-b-0">
                                <button @click="expanded = !expanded" class="flex flex-1 items-center justify-between py-0 font-semibold transition-all hover:underline [&[data-state=open]>svg]:rotate-180 w-full text-left text-md {{ request()->routeIs(['finance.*']) ? 'text-primary' : '' }}">
                                    {{ request()->routeIs('finance.transactions.*') ? 'Transactions' : (request()->routeIs('finance.categories.*') ? 'Categories' : 'Finance') }}
                                    <x-heroicon-o-chevron-down :class="{'rotate-180': expanded}" class="h-4 w-4 shrink-0 transition-transform duration-200" />
                                </button>
                                <div x-show="expanded" x-collapse>
                                    <div class="mt-2 flex flex-col gap-2 pl-4 border-l border-border ml-2">
                                        <a class="text-sm font-medium hover:underline py-1 {{ request()->routeIs('finance.transactions.index') ? 'text-primary' : '' }}" href="{{ route('finance.transactions.index') }}">Transactions</a>
                                        <a class="text-sm font-medium hover:underline py-1 {{ request()->routeIs('finance.categories.index') ? 'text-primary' : '' }}" href="{{ route('finance.categories.index') }}">Categories</a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(auth()->user()->role === 'admin')
                            <!-- Mobile Users Link -->
                            <a href="{{ route('users.index') }}" class="text-md font-semibold hover:underline border-b pb-4 {{ request()->routeIs('users.*') ? 'text-primary' : '' }}">Users</a>
                        @endif

                        @if(in_array(auth()->user()->role, ['admin', 'manager', 'gudang']))
                            <!-- Mobile Products Accordion -->
                            <div x-data="{ expanded: {{ request()->routeIs(['products.*', 'categories.*', 'units.*', 'bahan-baku.*', 'bom.*']) ? 'true' : 'false' }} }" class="border-b-0">
                                <button @click="expanded = !expanded" class="flex flex-1 items-center justify-between py-0 font-semibold transition-all hover:underline [&[data-state=open]>svg]:rotate-180 w-full text-left text-md {{ request()->routeIs(['products.*', 'categories.*', 'units.*', 'bahan-baku.*', 'bom.*']) ? 'text-primary' : '' }}">
                                    {{ request()->routeIs('products.*') ? 'Products' : (request()->routeIs('categories.*') ? 'Categories' : (request()->routeIs('units.*') ? 'Units' : (request()->routeIs('bahan-baku.*') ? 'Bahan Baku' : (request()->routeIs('bom.*') ? 'BOM' : 'Master Data')))) }}
                                    <x-heroicon-o-chevron-down :class="{'rotate-180': expanded}" class="h-4 w-4 shrink-0 transition-transform duration-200" />
                                </button>
                                <div x-show="expanded" x-collapse>
                                    <div class="mt-2 flex flex-col gap-2 pl-4 border-l border-border ml-2">
                                        <a class="text-sm font-medium hover:underline py-1 {{ request()->routeIs('products.index') ? 'text-primary' : '' }}" href="{{ route('products.index') }}">Products</a>
                                        <a class="text-sm font-medium hover:underline py-1 {{ request()->routeIs('categories.index') ? 'text-primary' : '' }}" href="{{ route('categories.index') }}">Categories</a>
                                        <a class="text-sm font-medium hover:underline py-1 {{ request()->routeIs('units.index') ? 'text-primary' : '' }}" href="{{ route('units.index') }}">Units</a>
                                        <a class="text-sm font-medium hover:underline py-1 {{ request()->routeIs('bahan-baku.index') ? 'text-primary' : '' }}" href="{{ route('bahan-baku.index') }}">Bahan Baku</a>
                                        <a class="text-sm font-medium hover:underline py-1 {{ request()->routeIs('bom.index') ? 'text-primary' : '' }}" href="{{ route('bom.index') }}">BOM</a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(in_array(auth()->user()->role, ['admin', 'manager', 'produksi']))
                            <!-- Mobile Produksi Link -->
                            <a href="{{ route('produksi.index') }}" class="text-md font-semibold hover:underline border-b pb-4 {{ request()->routeIs('produksi.*') ? 'text-primary' : '' }}">Produksi</a>
                        @endif

                        @if(in_array(auth()->user()->role, ['admin', 'manager', 'gudang']))
                            <!-- Mobile Gudang Accordion -->
                            <div x-data="{ expanded: {{ request()->routeIs(['gudang.*']) ? 'true' : 'false' }} }" class="border-b-0 border-t pt-4">
                                <button @click="expanded = !expanded" class="flex flex-1 items-center justify-between py-0 font-semibold transition-all hover:underline [&[data-state=open]>svg]:rotate-180 w-full text-left text-md {{ request()->routeIs(['gudang.*']) ? 'text-primary' : '' }}">
                                    {{ request()->routeIs('gudang.masuk.purchase') ? 'In-PO' : (request()->routeIs('gudang.masuk.produksi') ? 'In-Prod' : (request()->routeIs('gudang.keluar.produksi') ? 'Out-Prod' : (request()->routeIs('gudang.keluar.sale') ? 'Out-Sale' : (request()->routeIs('gudang.adjustment.*') ? 'Adjustment' : 'Gudang')))) }}
                                    <x-heroicon-o-chevron-down :class="{'rotate-180': expanded}" class="h-4 w-4 shrink-0 transition-transform duration-200" />
                                </button>
                                <div x-show="expanded" x-collapse>
                                    <div class="mt-2 flex flex-col gap-2 pl-4 border-l border-border ml-2">
                                        <a class="text-sm font-medium hover:underline py-1 {{ request()->routeIs('gudang.masuk.purchase') ? 'text-primary' : '' }}" href="{{ route('gudang.masuk.purchase') }}">In - Supplier PO</a>
                                        <a class="text-sm font-medium hover:underline py-1 {{ request()->routeIs('gudang.masuk.produksi') ? 'text-primary' : '' }}" href="{{ route('gudang.masuk.produksi') }}">In - Hasil Produksi</a>
                                        <a class="text-sm font-medium hover:underline py-1 {{ request()->routeIs('gudang.keluar.produksi') ? 'text-primary' : '' }}" href="{{ route('gudang.keluar.produksi') }}">Out - Ke Produksi</a>
                                        <a class="text-sm font-medium hover:underline py-1 {{ request()->routeIs('gudang.keluar.sale') ? 'text-primary' : '' }}" href="{{ route('gudang.keluar.sale') }}">Out - Ke Sales</a>
                                        <a class="text-sm font-medium hover:underline py-1 {{ request()->routeIs('gudang.adjustment.create') ? 'text-primary' : '' }}" href="{{ route('gudang.adjustment.create') }}">Stock Adjustment</a>
                                    </div>
                                </div>
                            </div>
                        @endif


                    <!-- Mobile User Menu -->
                        <div class="pt-4 mt-4 border-t border-border">
                            <div class="font-medium text-base text-foreground mb-2">{{ Auth::user()->name }}</div>
                            <div class="flex flex-col gap-3">
                                <a href="{{ route('profile.index') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input h-9 px-4 py-2 w-full {{ request()->routeIs('profile.*') ? 'bg-accent text-accent-foreground' : 'bg-background hover:bg-accent hover:text-accent-foreground' }}">
                                    Profile
                                </a>
                                @if(auth()->user()->role === 'admin')
                                <a href="{{ route('settings.index') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input h-9 px-4 py-2 w-full {{ request()->routeIs('settings.*') ? 'bg-accent text-accent-foreground' : 'bg-background hover:bg-accent hover:text-accent-foreground' }}">
                                    Settings
                                </a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}" class="w-full">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-9 px-4 py-2 w-full">
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
