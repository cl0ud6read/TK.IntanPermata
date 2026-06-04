<x-app-layout title="Gudang Keluar - Pengiriman Sales">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-foreground leading-tight">
            {{ __('Pengeluaran Barang Jadi untuk Penjualan (Sales)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-card overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-card-foreground">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-muted-foreground">
                            <thead class="text-xs text-muted-foreground uppercase bg-muted/50 border-b border-border">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No. Invoice Sales</th>
                                    <th scope="col" class="px-6 py-3">Customer</th>
                                    <th scope="col" class="px-6 py-3">Tanggal Transaksi</th>
                                    <th scope="col" class="px-6 py-3">Detail Barang Keluar</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3 text-center">Aksi (Kirim Barang)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sales as $item)
                                    <tr class="bg-card border-b border-border hover:bg-muted/50">
                                        <td class="px-6 py-4 font-medium text-foreground whitespace-nowrap">{{ $item->invoice_number }}</td>
                                        <td class="px-6 py-4">{{ $item->customer->name ?? 'Walk-in Customer' }}</td>
                                        <td class="px-6 py-4">{{ $item->sale_date->format('d M Y') }}</td>
                                        <td class="px-6 py-4">
                                            <ul class="list-disc list-inside text-xs">
                                                @foreach($item->items as $detail)
                                                    <li>{{ $detail->product->name ?? '-' }} : {{ $detail->quantity }} {{ $detail->product->unit->symbol ?? '' }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded">Menunggu Gudang</span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <form action="{{ route('gudang.keluar.sale.approve', $item) }}" method="POST" onsubmit="return confirm('Proses pengiriman barang ini ke customer? Stok akan otomatis dikurangi.');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="inline-flex items-center px-3 py-1 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                    Proses Pengiriman
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-muted-foreground">Tidak ada pesanan sales yang menunggu dikirim.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $sales->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
