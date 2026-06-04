<x-app-layout title="Gudang Masuk - Hasil Produksi">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-foreground leading-tight">
            {{ __('Penerimaan Barang Jadi (Hasil Produksi)') }}
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
                                    <th scope="col" class="px-6 py-3">No. Produksi</th>
                                    <th scope="col" class="px-6 py-3">Produk Jadi</th>
                                    <th scope="col" class="px-6 py-3">Target Awal</th>
                                    <th scope="col" class="px-6 py-3 text-green-600 font-bold">Good Products (Yield)</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3 text-center">Aksi (Terima)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($hasilProduksis as $item)
                                    <tr class="bg-card border-b border-border hover:bg-muted/50">
                                        <td class="px-6 py-4 font-medium text-foreground whitespace-nowrap">{{ $item->produksi->production_number ?? '-' }}</td>
                                        <td class="px-6 py-4">{{ $item->product->name ?? '-' }}</td>
                                        <td class="px-6 py-4">{{ $item->produksi->target_quantity ?? '-' }}</td>
                                        <td class="px-6 py-4 font-bold text-green-600 text-lg">{{ $item->quantity_produced }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded">Menunggu Gudang</span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <form action="{{ route('gudang.masuk.produksi.approve', $item) }}" method="POST" onsubmit="return confirm('Terima hasil produksi ini ke dalam stok gudang (Produk Jadi)?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="inline-flex items-center px-3 py-1 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                    Setorkan ke Gudang
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-muted-foreground">Tidak ada setoran hasil produksi yang pending.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $hasilProduksis->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
