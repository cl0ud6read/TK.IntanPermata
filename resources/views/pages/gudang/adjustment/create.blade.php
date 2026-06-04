<x-app-layout title="Stock Adjustment">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-foreground leading-tight">
            {{ __('Penyesuaian Stok (Stock Adjustment)') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="adjustmentForm()">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
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

            <div class="bg-card shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('gudang.adjustment.store') }}" method="POST" onsubmit="return confirm('Proses penyesuaian stok ini? Stok gudang akan langsung terupdate.');">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tipe Item -->
                            <div>
                                <x-input-label for="item_type" :value="__('Tipe Barang')" />
                                <select id="item_type" name="item_type" x-model="itemType" class="border-input bg-background text-foreground focus:border-primary focus:ring-primary rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">-- Pilih Tipe Barang --</option>
                                    <option value="bahan_baku">Bahan Baku (Material)</option>
                                    <option value="product">Barang Jadi (Produk Akhir)</option>
                                </select>
                                <x-input-error :messages="$errors->get('item_type')" class="mt-2" />
                            </div>

                            <!-- Item ID -->
                            <div>
                                <x-input-label for="item_id" :value="__('Barang')" />
                                <select id="item_id" name="item_id" x-model="itemId" class="border-input bg-background text-foreground focus:border-primary focus:ring-primary rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">-- Pilih Barang --</option>
                                    
                                    <!-- Bahan Baku Options -->
                                    <optgroup label="Bahan Baku" x-show="itemType === 'bahan_baku'">
                                        @foreach($bahanBakus as $bb)
                                            <option value="{{ $bb->id }}">{{ $bb->name }} ({{ $bb->sku }}) - Stok: {{ $bb->quantity }} {{ $bb->unit->symbol ?? '' }}</option>
                                        @endforeach
                                    </optgroup>

                                    <!-- Product Options -->
                                    <optgroup label="Barang Jadi" x-show="itemType === 'product'">
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->sku }}) - Stok: {{ $product->quantity }} {{ $product->unit->symbol ?? '' }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                <x-input-error :messages="$errors->get('item_id')" class="mt-2" />
                            </div>

                            <!-- Adjustment Type -->
                            <div>
                                <x-input-label for="adjustment_type" :value="__('Alasan Penyesuaian')" />
                                <select id="adjustment_type" name="adjustment_type" class="border-input bg-background text-foreground focus:border-primary focus:ring-primary rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">-- Pilih Alasan --</option>
                                    @foreach($adjustmentTypes as $type)
                                        <option value="{{ $type->value }}" {{ old('adjustment_type') == $type->value ? 'selected' : '' }}>{{ ucwords(str_replace('_', ' ', $type->value)) }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('adjustment_type')" class="mt-2" />
                            </div>

                            <!-- Movement Type (In/Out) -->
                            <div>
                                <x-input-label for="movement_type" :value="__('Aksi Stok')" />
                                <select id="movement_type" name="movement_type" class="border-input bg-background text-foreground focus:border-primary focus:ring-primary rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">-- Pilih Aksi --</option>
                                    <option value="in" {{ old('movement_type') == 'in' ? 'selected' : '' }}>(+) Tambah Stok / Masuk</option>
                                    <option value="out" {{ old('movement_type') == 'out' ? 'selected' : '' }}>(-) Kurangi Stok / Keluar</option>
                                </select>
                                <x-input-error :messages="$errors->get('movement_type')" class="mt-2" />
                            </div>

                            <!-- Quantity -->
                            <div>
                                <x-input-label for="quantity" :value="__('Kuantitas Penyesuaian')" />
                                <x-text-input id="quantity" class="block mt-1 w-full" type="number" min="1" name="quantity" :value="old('quantity')" placeholder="Jumlah stok yg disesuaikan" required />
                                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                            </div>

                            <!-- Notes -->
                            <div class="md:col-span-2">
                                <x-input-label for="notes" :value="__('Catatan Wajib (Detail Penyesuaian)')" />
                                <textarea id="notes" name="notes" class="border-input bg-background text-foreground focus:border-primary focus:ring-primary rounded-md shadow-sm block mt-1 w-full" rows="3" required placeholder="Jelaskan alasan penyesuaian (misal: Barang rusak akibat jatuh, dsb)">{{ old('notes') }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 gap-4 border-t border-border pt-4">
                            <x-primary-button class="bg-blue-600 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900">{{ __('Proses Penyesuaian') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('adjustmentForm', () => ({
                itemType: '{{ old('item_type', '') }}',
                itemId: '{{ old('item_id', '') }}',
            }))
        })
    </script>
</x-app-layout>
