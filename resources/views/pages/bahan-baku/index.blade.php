<x-app-layout title="Bahan Baku">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-foreground leading-tight">
                {{ __('Daftar Bahan Baku') }}
            </h2>
            <a href="{{ route('bahan-baku.create') }}" class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-primary-foreground uppercase tracking-widest hover:bg-primary/90 focus:bg-primary/90 active:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150">
                <x-heroicon-o-plus class="w-4 h-4 mr-2" />
                {{ __('Tambah Bahan Baku') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-card overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-card-foreground">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-muted-foreground">
                            <thead class="text-xs text-muted-foreground uppercase bg-muted/50 border-b border-border">
                                <tr>
                                    <th scope="col" class="px-6 py-3">SKU</th>
                                    <th scope="col" class="px-6 py-3">Nama</th>
                                    <th scope="col" class="px-6 py-3">Kategori</th>
                                    <th scope="col" class="px-6 py-3">Stok</th>
                                    <th scope="col" class="px-6 py-3">Min Stok</th>
                                    <th scope="col" class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bahanBakus as $item)
                                    <tr class="bg-card border-b border-border hover:bg-muted/50">
                                        <td class="px-6 py-4 font-medium text-foreground whitespace-nowrap">{{ $item->sku }}</td>
                                        <td class="px-6 py-4">{{ $item->name }}</td>
                                        <td class="px-6 py-4">{{ $item->category->name ?? '-' }}</td>
                                        <td class="px-6 py-4">
                                            @if($item->is_below_min_stock)
                                                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded">{{ $item->quantity }} {{ $item->unit->symbol ?? '' }}</span>
                                            @else
                                                {{ $item->quantity }} {{ $item->unit->symbol ?? '' }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">{{ $item->min_stock }}</td>
                                        <td class="px-6 py-4 flex gap-2">
                                            <a href="{{ route('bahan-baku.edit', $item) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                            <form action="{{ route('bahan-baku.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-muted-foreground">Tidak ada data bahan baku.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $bahanBakus->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
