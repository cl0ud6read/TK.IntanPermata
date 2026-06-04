<x-app-layout title="Detail BOM">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-foreground leading-tight">
                {{ __('Detail BOM') }}: {{ $bom->name }}
            </h2>
            <a href="{{ route('bom.index') }}" class="text-sm text-muted-foreground hover:text-foreground">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Info BOM -->
                <div class="md:col-span-1">
                    <div class="bg-card shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium border-b border-border pb-2 mb-4">Informasi BOM</h3>
                            
                            <dl class="space-y-3 text-sm">
                                <div>
                                    <dt class="text-muted-foreground font-medium">Nama BOM</dt>
                                    <dd class="text-foreground font-semibold">{{ $bom->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-muted-foreground font-medium">Produk Akhir</dt>
                                    <dd class="text-foreground font-semibold">{{ $bom->product->name ?? '-' }} ({{ $bom->product->sku ?? '-' }})</dd>
                                </div>
                                <div>
                                    <dt class="text-muted-foreground font-medium">Status</dt>
                                    <dd class="mt-1">
                                        @if($bom->is_active)
                                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded">Aktif</span>
                                        @else
                                            <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded">Non-aktif</span>
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-muted-foreground font-medium">Catatan</dt>
                                    <dd class="text-foreground">{{ $bom->notes ?: '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-muted-foreground font-medium">Dibuat Pada</dt>
                                    <dd class="text-foreground">{{ $bom->created_at->format('d M Y, H:i') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Komposisi -->
                <div class="md:col-span-2">
                    <div class="bg-card shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium border-b border-border pb-2 mb-4">Komposisi Resep (Per 1 Unit Produk)</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left">
                                    <thead class="text-xs text-muted-foreground uppercase bg-muted/50 border-b border-border">
                                        <tr>
                                            <th class="px-4 py-3">Bahan Baku</th>
                                            <th class="px-4 py-3">SKU</th>
                                            <th class="px-4 py-3 text-right">Kuantitas</th>
                                            <th class="px-4 py-3">Satuan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bom->items as $item)
                                            <tr class="border-b border-border hover:bg-muted/50">
                                                <td class="px-4 py-3 font-medium">{{ $item->bahanBaku->name ?? '-' }}</td>
                                                <td class="px-4 py-3">{{ $item->bahanBaku->sku ?? '-' }}</td>
                                                <td class="px-4 py-3 text-right font-semibold">{{ $item->quantity }}</td>
                                                <td class="px-4 py-3">{{ $item->bahanBaku->unit->symbol ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
