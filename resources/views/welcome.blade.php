<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TK. Intan Permata - Smart ERP System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts / Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc; /* slate-50 */
            color: #0f172a; /* slate-900 */
            margin: 0;
            padding: 0;
        }
        
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .gradient-text {
            background: linear-gradient(to right, #4f46e5, #9333ea);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .blob {
            position: absolute;
            filter: blur(80px);
            z-index: -1;
            opacity: 0.15;
            animation: float 10s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-20px) scale(1.05); }
            100% { transform: translateY(0px) scale(1); }
        }

        .feature-card {
            background: white;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            border-color: rgba(99, 102, 241, 0.3); /* indigo-500 */
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col relative overflow-x-hidden">

    <!-- Background Glow Blobs -->
    <div class="blob bg-indigo-500 rounded-full w-96 h-96 top-0 left-[-10%]"></div>
    <div class="blob bg-purple-500 rounded-full w-[30rem] h-[30rem] bottom-[-20%] right-[-10%]" style="animation-delay: -5s;"></div>

    <!-- Navigation -->
    <nav class="glass-nav fixed w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo_circle.png') }}" alt="TK. Intan Permata Logo" class="h-10 w-10 object-contain shadow-sm rounded-full border border-indigo-100">
                    <span class="font-bold text-xl tracking-tight text-slate-800">TK. Intan Permata</span>
                </div>
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 px-5 py-2.5 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                Masuk Dashboard &rarr;
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 px-4 py-2 transition-colors">
                                Log in
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col justify-center pt-24 pb-16 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            
            <!-- Hero Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center mt-10 sm:mt-20">
                <!-- Left Side: Text Content -->
                <div class="text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-sm font-semibold mb-6 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                        Sistem ERP Terpadu
                    </div>
                    
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight mb-6 leading-tight text-slate-900">
                        Kelola Bisnis <br>
                        <span class="gradient-text">Lebih Cerdas</span>
                    </h1>
                    
                    <p class="mt-6 text-lg text-slate-600 leading-relaxed max-w-lg">
                        Sistem Enterprise Resource Planning (ERP) khusus untuk TK. Intan Permata. Pantau stok barang, kelola alur produksi, dan sajikan laporan akurat secara real-time.
                    </p>
                    
                    <div class="mt-10 flex flex-col sm:flex-row gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-4 rounded-xl shadow-lg hover:shadow-indigo-500/30 transition-all duration-300 transform hover:-translate-y-1 flex justify-center items-center gap-2">
                                Buka Dashboard
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-4 rounded-xl shadow-lg hover:shadow-indigo-500/30 transition-all duration-300 transform hover:-translate-y-1 flex justify-center items-center gap-2">
                                Akses Sistem
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" /></svg>
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Right Side: Visual Mockup -->
                <div class="relative mt-12 lg:mt-0 w-full max-w-lg mx-auto lg:ml-auto">
                    <!-- Decorative background glow -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-[2rem] blur-xl opacity-20 animate-pulse"></div>
                    
                    <div class="relative bg-white/80 backdrop-blur-xl border border-white/60 rounded-[2rem] shadow-2xl p-6 lg:p-8 overflow-visible transform transition-transform duration-500 hover:scale-[1.02]">
                        <!-- Mockup Header -->
                        <div class="flex justify-between items-center mb-8">
                            <div>
                                <h4 class="text-slate-800 font-bold text-xl">Target Produksi</h4>
                                <p class="text-slate-500 text-sm font-medium mt-1">Minggu Ini</p>
                            </div>
                            <div class="bg-indigo-50 text-indigo-700 px-4 py-1.5 rounded-full text-sm font-bold border border-indigo-100 shadow-sm flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" /></svg>
                                +14.5%
                            </div>
                        </div>

                        <!-- Bar Chart Mockup -->
                        <div class="flex items-end justify-between h-48 gap-3 mb-6 border-b border-slate-100 pb-3">
                            <!-- Bar 1 -->
                            <div class="w-full flex flex-col justify-end items-center group relative">
                                <div class="w-full bg-slate-100 rounded-t-xl h-[40%] group-hover:bg-indigo-300 transition-all duration-300 relative">
                                    <div class="absolute -top-8 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 bg-slate-800 text-white text-xs py-1 px-2.5 rounded shadow-lg transition-all duration-300 z-10 font-medium">400</div>
                                </div>
                                <span class="text-xs text-slate-400 mt-3 font-semibold uppercase tracking-wider">Sen</span>
                            </div>
                            <!-- Bar 2 -->
                            <div class="w-full flex flex-col justify-end items-center group relative">
                                <div class="w-full bg-gradient-to-t from-indigo-500 to-indigo-400 rounded-t-xl h-[75%] shadow-[0_0_20px_rgba(99,102,241,0.4)] relative transform group-hover:scale-y-105 transition-all duration-300 origin-bottom">
                                    <div class="absolute -top-8 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 bg-slate-800 text-white text-xs py-1 px-2.5 rounded shadow-lg transition-all duration-300 z-10 font-medium">750</div>
                                </div>
                                <span class="text-xs text-indigo-600 mt-3 font-bold uppercase tracking-wider">Sel</span>
                            </div>
                            <!-- Bar 3 -->
                            <div class="w-full flex flex-col justify-end items-center group relative">
                                <div class="w-full bg-slate-100 rounded-t-xl h-[55%] group-hover:bg-indigo-300 transition-all duration-300 relative">
                                     <div class="absolute -top-8 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 bg-slate-800 text-white text-xs py-1 px-2.5 rounded shadow-lg transition-all duration-300 z-10 font-medium">550</div>
                                </div>
                                <span class="text-xs text-slate-400 mt-3 font-semibold uppercase tracking-wider">Rab</span>
                            </div>
                            <!-- Bar 4 -->
                            <div class="w-full flex flex-col justify-end items-center group relative">
                                <div class="w-full bg-slate-100 rounded-t-xl h-[30%] group-hover:bg-indigo-300 transition-all duration-300 relative">
                                     <div class="absolute -top-8 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 bg-slate-800 text-white text-xs py-1 px-2.5 rounded shadow-lg transition-all duration-300 z-10 font-medium">300</div>
                                </div>
                                <span class="text-xs text-slate-400 mt-3 font-semibold uppercase tracking-wider">Kam</span>
                            </div>
                            <!-- Bar 5 -->
                            <div class="w-full flex flex-col justify-end items-center group relative">
                                <div class="w-full bg-slate-100 rounded-t-xl h-[85%] group-hover:bg-indigo-300 transition-all duration-300 relative">
                                     <div class="absolute -top-8 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 bg-slate-800 text-white text-xs py-1 px-2.5 rounded shadow-lg transition-all duration-300 z-10 font-medium">850</div>
                                </div>
                                <span class="text-xs text-slate-400 mt-3 font-semibold uppercase tracking-wider">Jum</span>
                            </div>
                        </div>

                        <!-- Bottom Stats Mockup -->
                        <div class="grid grid-cols-2 gap-5 mt-2">
                            <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-6 h-6 rounded-md bg-indigo-50 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" /></svg>
                                    </div>
                                    <span class="text-[11px] text-slate-500 font-bold uppercase tracking-wider">Total Produksi</span>
                                </div>
                                <div class="text-2xl font-black text-slate-800">2,850 <span class="text-sm text-slate-400 font-medium">pcs</span></div>
                            </div>
                            <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-6 h-6 rounded-md bg-green-50 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-green-600" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                    </div>
                                    <span class="text-[11px] text-slate-500 font-bold uppercase tracking-wider">Status Gudang</span>
                                </div>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="relative flex h-3 w-3">
                                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                      <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                                    </span>
                                    <span class="text-base font-bold text-slate-800">Optimal</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Floating badge -->
                        <div class="absolute -right-3 -bottom-6 lg:-right-6 bg-white shadow-[0_10px_40px_rgba(0,0,0,0.1)] rounded-2xl p-4 flex items-center gap-4 border border-slate-100 animate-bounce z-20" style="animation-duration: 3s;">
                            <div class="bg-green-100 p-2.5 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <div class="pr-2">
                                <p class="text-xs text-slate-500 font-semibold mb-0.5">Data Real-time</p>
                                <p class="text-sm font-bold text-slate-900 leading-none">Sinkronisasi Aktif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features Grid -->
            <div class="mt-28 mx-auto w-full grid grid-cols-1 md:grid-cols-3 gap-8 pb-10" style="max-width: 1152px;">
                <!-- Feature 1 -->
                <div class="feature-card rounded-2xl p-8">
                    <div class="w-14 h-14 rounded-xl bg-indigo-50 flex items-center justify-center mb-6 border border-indigo-100">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-indigo-600"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Manajemen Inventaris</h3>
                    <p class="text-slate-600 leading-relaxed" style="text-align: justify;">Pemantauan stok barang masuk dan keluar secara real-time. Cegah kehabisan bahan baku dengan sistem pencatatan cerdas.</p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card rounded-2xl p-8">
                    <div class="w-14 h-14 rounded-xl bg-purple-50 flex items-center justify-center mb-6 border border-purple-100">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-purple-600"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Manajemen Produksi</h3>
                    <p class="text-slate-600 leading-relaxed" style="text-align: justify;">Pencatatan resep bahan baku (BOM) hingga pemantauan status produksi harian secara real-time yang terintegrasi penuh dengan stok persediaan.</p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card rounded-2xl p-8">
                    <div class="w-14 h-14 rounded-xl bg-pink-50 flex items-center justify-center mb-6 border border-pink-100">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-pink-600"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Hak Akses Terstruktur</h3>
                    <p class="text-slate-600 leading-relaxed" style="text-align: justify;">Sistem Role-Based Access Control (RBAC) aman yang menyesuaikan tampilan layar secara otomatis untuk Admin, Manager, Gudang, dan Produksi.</p>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full py-8 text-center mt-auto relative z-10" style="background: linear-gradient(135deg, #e0e7ff 0%, #ede9fe 100%); border-top: 1px solid #c7d2fe;">
        <p class="text-sm font-semibold" style="color: #4f46e5;">
            &copy; {{ date('Y') }} TK. Intan Permata ERP System. All rights reserved.
        </p>
    </footer>

</body>
</html>
