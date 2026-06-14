@props(['title' => ''])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full print:h-auto bg-slate-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}{{ !empty($title) ? ' | ' . $title : '' }}</title>
        <link rel="icon" href="{{ asset('images/logo_circle.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="h-full print:h-auto font-sans antialiased text-slate-900 bg-slate-50" x-data="{ sidebarOpen: false }">
        
        <div class="flex h-screen print:h-auto overflow-hidden print:overflow-visible">
            <!-- Sidebar Navigation -->
            @include('layouts.navigation')

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden print:overflow-visible relative bg-slate-50 print:bg-white print:block">
                
                <!-- Mobile Header & Topbar -->
                <header class="bg-white border-b border-slate-200 shadow-sm z-30 shrink-0 print:hidden">
                    <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 h-16">
                        <!-- Mobile Menu Button -->
                        <button @click="sidebarOpen = true" class="lg:hidden p-2 -ml-2 mr-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-md focus:outline-none transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                        
                        <!-- Page Heading Title (if any) -->
                        <div class="flex-1 w-full">
                            @isset($header)
                                {{ $header }}
                            @endisset
                        </div>

                        <!-- User Menu (Right side) -->
                        <div class="flex items-center gap-3 shrink-0 ml-4">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="flex items-center gap-2 p-1 rounded-full hover:bg-slate-100 transition-colors border border-transparent focus:border-slate-200 outline-none">
                                        <span class="hidden md:block text-sm font-semibold text-slate-700 ml-2">{{ Auth::user()->name }}</span>
                                        <x-avatar :name="Auth::user()->name" />
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="px-4 py-3 border-b border-slate-100">
                                        <p class="text-sm font-medium text-slate-900 truncate">{{ Auth::user()->name }}</p>
                                        <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mt-0.5">{{ Auth::user()->role }}</p>
                                    </div>
                                    <x-dropdown-link :href="route('profile.index')">
                                        Profil
                                    </x-dropdown-link>

                                    @if(auth()->user()->role === 'admin')
                                    <x-dropdown-link :href="route('settings.index')">
                                        Pengaturan
                                    </x-dropdown-link>
                                    @endif

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault(); this.closest('form').submit();"
                                                class="text-red-600 hover:text-red-700 hover:bg-red-50 focus:bg-red-50 focus:text-red-700">
                                            Keluar
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                </header>

                <!-- Page Content & Footer Wrapper -->
                <div class="flex-1 overflow-y-auto overflow-x-hidden print:overflow-visible flex flex-col print:block">
                    <main class="p-4 sm:p-6 lg:p-8 flex-1 print:p-0 print:m-0">
                        {{ $slot }}
                    </main>

                    <!-- Footer -->
                    @include('layouts.footer')
                </div>
            </div>
        </div>

        <x-toaster />
        <livewire:components.delete-modal />
        @livewireScripts
        @stack('scripts')
        <script>
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('open-print-window', (event) => {
                    let url = event.url;
                    if (url) {
                        const params = new URLSearchParams(window.location.search);
                        const periodFilter = params.get('filters[date_period]');

                        if (periodFilter && !url.includes('period=')) {
                            url += (url.includes('?') ? '&' : '?') + 'period=' + periodFilter;
                        }

                        window.open(url, '_blank');
                    }
                });
            });

            // Global Currency Formatter
            window.currencySymbol = "{{ \App\Models\Setting::get('currency_symbol', 'Rp') }}";
            window.currencyPosition = "{{ \App\Models\Setting::get('currency_position', 'left') }}";
            window.currencyFraction = parseInt("{{ \App\Models\Setting::get('currency_fraction_digits', 0) }}");
            window.thousandSeparator = "{{ \App\Models\Setting::get('currency_thousand_separator', '.') }}";
            window.decimalSeparator = "{{ \App\Models\Setting::get('currency_decimal_separator', ',') }}";

            window.formatMoney = function(val) {
                let amount = parseFloat(val) || 0;
                let isNegative = amount < 0;
                amount = Math.abs(amount);

                let strAmount = amount.toFixed(window.currencyFraction);
                let parts = strAmount.split('.');
                let integerPart = parts[0];
                let decimalPart = parts.length > 1 ? window.decimalSeparator + parts[1] : '';

                let rgx = /(\d+)(\d{3})/;
                while (rgx.test(integerPart)) {
                    integerPart = integerPart.replace(rgx, '$1' + window.thousandSeparator + '$2');
                }

                let num = integerPart + decimalPart;
                if (isNegative) num = '-' + num;

                return window.currencyPosition === 'left' ? window.currencySymbol + ' ' + num : num + ' ' + window.currencySymbol;
            };

            window.formatCurrency = window.formatMoney;
        </script>
    </body>
</html>
