<x-app-layout title="Detail Produksi">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-foreground leading-tight">
                {{ __('Detail Produksi') }}: {{ $produksi->production_number }}
            </h2>
            <a href="{{ route('produksi.index') }}" class="text-sm text-muted-foreground hover:text-foreground">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Info Utama -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-card shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium border-b border-border pb-2 mb-4">Informasi Produksi</h3>
                            
                            <dl class="space-y-3 text-sm">
                                <div>
                                    <dt class="text-muted-foreground font-medium">Nomor</dt>
                                    <dd class="text-foreground font-semibold">{{ $produksi->production_number }}</dd>
                                </div>
                                <div>
                                    <dt class="text-muted-foreground font-medium">Produk Target</dt>
                                    <dd class="text-foreground">{{ $produksi->product->name ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-muted-foreground font-medium">BOM yang Digunakan</dt>
                                    <dd class="text-foreground">{{ $produksi->bom->name ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-muted-foreground font-medium">Target Qty</dt>
                                    <dd class="text-foreground font-semibold">{{ $produksi->target_quantity }}</dd>
                                </div>
                                <div>
                                    <dt class="text-muted-foreground font-medium">Status</dt>
                                    <dd class="mt-1">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'in_progress' => 'bg-blue-100 text-blue-800',
                                                'completed' => 'bg-green-100 text-green-800',
                                                'failed' => 'bg-red-100 text-red-800',
                                            ];
                                            $color = $statusColors[$produksi->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-2 py-1 text-xs font-medium rounded {{ $color }}">
                                            {{ strtoupper($produksi->status) }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-muted-foreground font-medium">Dibuat Oleh</dt>
                                    <dd class="text-foreground">{{ $produksi->creator->name ?? '-' }}</dd>
                                </div>
                            </dl>

                            <!-- State Machine Actions -->
                            @if(!in_array($produksi->status, ['completed', 'failed']))
                                <div class="mt-6 pt-4 border-t border-border">
                                    <h4 class="text-sm font-medium mb-3">Update Status</h4>
                                    <div class="flex flex-col gap-2">
                                        @if($produksi->status === 'pending')
                                            <!-- Check if all materials are supplied -->
                                            @php
                                                $allSupplied = $produksi->detailProduksi->every(fn($item) => $item->status === 'supplied' || $item->status === 'approved');
                                            @endphp
                                            
                                            @if($allSupplied)
                                                <form action="{{ route('produksi.update_status', $produksi) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="in_progress">
                                                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                                        Mulai Produksi
                                                    </button>
                                                </form>
                                            @else
                                                <div class="text-xs text-yellow-600 bg-yellow-50 p-2 rounded">
                                                    Menunggu Gudang menyalurkan seluruh bahan baku sebelum produksi dapat dimulai.
                                                </div>
                                            @endif
                                            
                                            <form action="{{ route('produksi.update_status', $produksi) }}" method="POST" onsubmit="return confirm('Batalkan produksi?');">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="failed">
                                                <button type="submit" class="w-full mt-2 flex justify-center py-2 px-4 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50">
                                                    Batalkan (Failed)
                                                </button>
                                            </form>
                                        @elseif($produksi->status === 'in_progress')
                                            <form action="{{ route('produksi.update_status', $produksi) }}" method="POST" onsubmit="return confirm('Selesaikan produksi? Pastikan barang jadi sudah dihitung.');">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                                                    Selesai & Setor ke Gudang
                                                </button>
                                            </form>

                                            <form action="{{ route('produksi.update_status', $produksi) }}" method="POST" onsubmit="return confirm('Tandai gagal? Bahan baku akan hangus.');">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="failed">
                                                <button type="submit" class="w-full mt-2 flex justify-center py-2 px-4 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50">
                                                    Gagal Produksi (Failed)
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Material & Hasil -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Material yang Dibutuhkan -->
                    <div class="bg-card shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium border-b border-border pb-2 mb-4">Status Permintaan Bahan Baku (Gudang Keluar)</h3>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left">
                                    <thead class="text-xs text-muted-foreground uppercase bg-muted/50 border-b border-border">
                                        <tr>
                                            <th class="px-4 py-3">Bahan Baku</th>
                                            <th class="px-4 py-3 text-right">Qty Diminta</th>
                                            <th class="px-4 py-3 text-right">Qty Diterima</th>
                                            <th class="px-4 py-3 text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($produksi->detailProduksi as $detail)
                                            <tr class="border-b border-border hover:bg-muted/50">
                                                <td class="px-4 py-3 font-medium">{{ $detail->bahanBaku->name ?? '-' }} ({{ $detail->bahanBaku->sku ?? '-' }})</td>
                                                <td class="px-4 py-3 text-right">{{ $detail->quantity_requested }}</td>
                                                <td class="px-4 py-3 text-right">{{ $detail->quantity_supplied }}</td>
                                                <td class="px-4 py-3 text-center">
                                                    @if($detail->status === 'pending')
                                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded">Menunggu Gudang</span>
                                                    @elseif($detail->status === 'supplied' || $detail->status === 'approved')
                                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded">Tersalurkan</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Hasil Produksi -->
                    <div class="bg-card shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-center border-b border-border pb-2 mb-4">
                                <h3 class="text-lg font-medium">Hasil Produksi (Gudang Masuk)</h3>
                            </div>
                            
                            @if($produksi->hasilProduksi->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm text-left">
                                        <thead class="text-xs text-muted-foreground uppercase bg-muted/50 border-b border-border">
                                            <tr>
                                                <th class="px-4 py-3">Produk</th>
                                                <th class="px-4 py-3 text-right">Qty Dihasilkan</th>
                                                <th class="px-4 py-3 text-center">Status Setoran</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($produksi->hasilProduksi as $hasil)
                                                <tr class="border-b border-border">
                                                    <td class="px-4 py-3 font-medium">{{ $hasil->product->name ?? '-' }}</td>
                                                    <td class="px-4 py-3 text-right">{{ $hasil->quantity_produced }}</td>
                                                    <td class="px-4 py-3 text-center">
                                                        @if($hasil->status === 'pending_gudang')
                                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded">Menunggu Gudang Approve</span>
                                                        @elseif($hasil->status === 'approved')
                                                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded">Masuk Gudang</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4 text-muted-foreground text-sm">
                                    Belum ada hasil produksi disetor. Hasil akan tergenerate saat Produksi ditandai "Selesai".
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
