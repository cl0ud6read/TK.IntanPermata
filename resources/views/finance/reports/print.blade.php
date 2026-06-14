<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Arus Kas - {{ $storeName }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @media print {
            body { background-color: white !important; padding: 0 !important; margin: 0 !important; }
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print { display: none !important; }
            @page { 
                size: A4 portrait;
                margin: 10mm; 
            }
            
            /* Print Specific Overrides */
            .print-container { max-width: 100% !important; width: 100% !important; padding: 0 !important; margin: 0 !important; box-shadow: none !important; border: none !important; border-radius: 0 !important; }
            .print-table-container { border: 1px solid #1e293b !important; border-radius: 0 !important; margin-bottom: 15px !important; }
            .print-table { font-size: 10px !important; width: 100% !important; color: black !important; }
            .print-table th { background-color: #f1f5f9 !important; font-size: 9px !important; border-bottom: 1px solid #1e293b !important; border-top: 1px solid #1e293b !important; padding: 6px 8px !important;}
            .print-table td { border-bottom: 1px solid #e2e8f0 !important; padding: 6px 8px !important; white-space: nowrap !important; }
            .print-desc { white-space: normal !important; word-wrap: break-word !important; min-width: 150px !important; }
            .print-signatures { margin-top: 20px !important; font-size: 10px !important; page-break-inside: avoid; }

            table { page-break-inside: auto; width: 100% !important; }
            tr { page-break-inside: avoid; page-break-after: auto; }
            thead { display: table-header-group; }
            tfoot { display: table-footer-group; }
        }
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 p-4 sm:p-8">

    <div class="print-container max-w-[1000px] mx-auto bg-white sm:shadow-2xl sm:rounded-2xl border border-slate-200 overflow-hidden">
        
        <!-- Print Button Header -->
        <div class="bg-slate-50 border-b border-slate-200 px-6 sm:px-10 py-5 flex justify-between items-center no-print">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800 leading-tight">Pratinjau Dokumen</h2>
                    <p class="text-xs text-slate-500 font-medium">Periksa kembali data sebelum mencetak.</p>
                </div>
            </div>
            <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center gap-2 transform hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0v3.396c0 .61.49 1.104 1.1 1.104h8.3c.61 0 1.1-.494 1.1-1.104V7.057Z" /></svg>
                Cetak Laporan
            </button>
        </div>

        <div class="p-8 sm:p-12 print-container">
            <!-- Document Header -->
            <div class="flex justify-between items-start border-b-2 border-slate-800 pb-6 mb-8">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/logo_circle.png') }}" class="w-16 h-16 rounded-full border border-slate-200 shadow-sm" alt="Logo">
                    <div>
                        <h1 class="text-3xl font-black tracking-tight text-slate-900 uppercase">{{ $storeName }}</h1>
                        <p class="text-slate-500 mt-1 font-medium text-sm">{{ $storeAddress }}</p>
                        @if($storePhone !== '-')
                            <p class="text-slate-500 font-medium text-sm">Telp: {{ $storePhone }}</p>
                        @endif
                    </div>
                </div>
                <div class="text-right">
                    <h2 class="text-2xl font-black text-indigo-700 uppercase tracking-widest mb-3">Laporan Arus Kas</h2>
                    <div class="bg-indigo-50/50 border border-indigo-100 rounded-xl px-4 py-2 inline-block text-left shadow-sm">
                        <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-wider mb-0.5">Periode Laporan</p>
                        <p class="text-sm font-bold text-slate-800">{{ $periodText }}</p>
                    </div>
                </div>
            </div>

            <!-- Meta Info -->
            <div class="flex justify-between items-center text-xs font-semibold text-slate-500 mb-6 bg-slate-50 px-4 py-2 rounded-lg border border-slate-100">
                <div>Dicetak pada: <span class="text-slate-800">{{ now()->setTimezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') }}</span></div>
                <div>Dicetak oleh: <span class="text-slate-800">{{ auth()->user()->name ?? 'Admin' }}</span></div>
            </div>

            <!-- Table -->
            <div class="rounded-xl overflow-hidden border border-slate-200 print-table-container">
                <table class="w-full text-left text-sm whitespace-nowrap print-table">
                    <thead class="bg-slate-100 text-slate-700 uppercase text-[11px] font-black tracking-wider">
                        <tr>
                            <th class="px-5 py-4 text-center border-b border-slate-200 w-12">No</th>
                            <th class="px-5 py-4 border-b border-slate-200">Tanggal</th>
                            <th class="px-5 py-4 border-b border-slate-200 text-center">Tipe</th>
                            <th class="px-5 py-4 border-b border-slate-200">Kategori</th>
                            <th class="px-5 py-4 border-b border-slate-200 w-full">Deskripsi</th>
                            <th class="px-5 py-4 border-b border-slate-200 text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                        @forelse($cashFlows as $index => $cf)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-5 py-3.5 text-center text-slate-500">{{ $index + 1 }}</td>
                                <td class="px-5 py-3.5">{{ $cf->transaction_date->translatedFormat('d M Y') }}</td>
                                <td class="px-5 py-3.5 text-center">
                                    @if($cf->category->type === \App\Enums\FinanceCategoryType::Income)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-black bg-emerald-100 text-emerald-700 border border-emerald-200 uppercase tracking-widest">Pemasukan</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-black bg-rose-100 text-rose-700 border border-rose-200 uppercase tracking-widest">Pengeluaran</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 font-bold text-slate-900">{{ $cf->category->name ?? '-' }}</td>
                                <td class="px-5 py-3.5 whitespace-normal min-w-[200px] leading-snug print-desc">
                                    {{ $cf->description }}
                                    @if($cf->external_reference)
                                        <div class="text-[11px] text-slate-400 mt-1 font-semibold">Ref: {{ $cf->external_reference }}</div>
                                    @else
                                        <div class="text-[11px] text-slate-400 mt-1 font-semibold">Ref: {{ $cf->code }}</div>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-right font-black text-slate-900 tracking-tight text-base">
                                    Rp {{ number_format($cf->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-12 text-center text-slate-500 font-medium">Tidak ada transaksi pada periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Summary Section -->
            <div class="mt-8 flex justify-end">
                <div class="w-full sm:w-1/2 lg:w-2/5 bg-slate-50 rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <div class="flex justify-between items-center py-2.5 border-b border-slate-200 border-dashed">
                        <span class="text-slate-500 font-semibold text-sm">Saldo Awal ({{ \Carbon\Carbon::parse($openingBalanceDate)->translatedFormat('d M') }})</span>
                        <span class="font-bold text-slate-700">Rp {{ number_format($openingBalanceAmount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2.5 border-b border-slate-200 border-dashed">
                        <span class="text-slate-500 font-semibold text-sm">Total Pemasukan</span>
                        <span class="font-black text-emerald-600">+ Rp {{ number_format($totalIncome, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2.5 border-b border-slate-200 border-dashed">
                        <span class="text-slate-500 font-semibold text-sm">Total Pengeluaran</span>
                        <span class="font-black text-rose-600">- Rp {{ number_format($totalExpense, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-5 mt-2 border-t-2 border-slate-800">
                        <span class="text-slate-900 font-black uppercase tracking-widest text-xs">Estimasi Saldo Akhir</span>
                        <span class="font-black text-indigo-700 text-base">Rp {{ number_format($estimatedFinalBalance, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Signatures -->
            <div class="mt-20 grid grid-cols-3 gap-8 text-center text-sm font-medium print-signatures">
                <div>
                    <p class="text-slate-500 mb-20 font-semibold">Dibuat Oleh,</p>
                    <div class="w-48 mx-auto border-t border-slate-400 pt-2 text-slate-800 font-bold uppercase tracking-wider">Admin Keuangan</div>
                </div>
                <div>
                    <p class="text-slate-500 mb-20 font-semibold">Diperiksa Oleh,</p>
                    <div class="w-48 mx-auto border-t border-slate-400 pt-2 text-slate-800 font-bold uppercase tracking-wider">Manajer Operasional</div>
                </div>
                <div>
                    <p class="text-slate-500 mb-20 font-semibold">Disetujui Oleh,</p>
                    <div class="w-48 mx-auto border-t border-slate-400 pt-2 text-slate-800 font-bold uppercase tracking-wider">Pemilik Toko</div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
