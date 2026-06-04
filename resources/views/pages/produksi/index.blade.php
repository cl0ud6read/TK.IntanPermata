<x-app-layout title="Daftar Produksi">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-foreground leading-tight">
                {{ __('Daftar Produksi') }}
            </h2>
            <a href="{{ route('produksi.create') }}" class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-primary-foreground uppercase tracking-widest hover:bg-primary/90 focus:bg-primary/90 active:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150">
                <x-heroicon-o-plus class="w-4 h-4 mr-2" />
                {{ __('Request Produksi') }}
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
                                    <th scope="col" class="px-6 py-3">Nomor Produksi</th>
                                    <th scope="col" class="px-6 py-3">Produk</th>
                                    <th scope="col" class="px-6 py-3">Target Qty</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Tanggal Mulai</th>
                                    <th scope="col" class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($produksis as $item)
                                    <tr class="bg-card border-b border-border hover:bg-muted/50">
                                        <td class="px-6 py-4 font-medium text-foreground whitespace-nowrap">{{ $item->production_number }}</td>
                                        <td class="px-6 py-4">{{ $item->product->name ?? '-' }}</td>
                                        <td class="px-6 py-4">{{ $item->target_quantity }}</td>
                                        <td class="px-6 py-4">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'in_progress' => 'bg-blue-100 text-blue-800',
                                                    'completed' => 'bg-green-100 text-green-800',
                                                    'failed' => 'bg-red-100 text-red-800',
                                                ];
                                                $color = $statusColors[$item->status] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="px-2 py-1 text-xs font-medium rounded {{ $color }}">
                                                {{ strtoupper($item->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">{{ $item->start_date ? $item->start_date->format('d M Y') : '-' }}</td>
                                        <td class="px-6 py-4 flex gap-2">
                                            <a href="{{ route('produksi.show', $item) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-muted-foreground">Tidak ada data produksi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $produksis->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
