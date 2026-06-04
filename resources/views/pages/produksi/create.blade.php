<x-app-layout title="Request Produksi Baru">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-foreground leading-tight">
                {{ __('Request Produksi Baru') }}
            </h2>
            <a href="{{ route('produksi.index') }}" class="text-sm text-muted-foreground hover:text-foreground">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-card shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('produksi.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Product -->
                            <div class="md:col-span-2">
                                <x-input-label for="product_id" :value="__('Produk yang akan diproduksi (Barang Jadi)')" />
                                <select id="product_id" name="product_id" class="border-input bg-background text-foreground focus:border-primary focus:ring-primary rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }} ({{ $product->sku }}) - {{ $product->boms->first()->name ?? 'Tanpa BOM' }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
                                <p class="text-xs text-muted-foreground mt-1">Hanya produk yang memiliki BOM Aktif yang dapat dipilih.</p>
                            </div>

                            <!-- Target Quantity -->
                            <div>
                                <x-input-label for="target_quantity" :value="__('Target Kuantitas Produksi')" />
                                <x-text-input id="target_quantity" class="block mt-1 w-full" type="number" min="1" name="target_quantity" :value="old('target_quantity', 1)" required />
                                <x-input-error :messages="$errors->get('target_quantity')" class="mt-2" />
                            </div>

                            <!-- Start Date -->
                            <div>
                                <x-input-label for="start_date" :value="__('Tanggal Mulai (Opsional)')" />
                                <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" :value="old('start_date')" />
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                            </div>

                            <!-- Notes -->
                            <div class="md:col-span-2">
                                <x-input-label for="notes" :value="__('Catatan/Deskripsi')" />
                                <textarea id="notes" name="notes" class="border-input bg-background text-foreground focus:border-primary focus:ring-primary rounded-md shadow-sm block mt-1 w-full" rows="3">{{ old('notes') }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 gap-4">
                            <x-secondary-button type="button" onclick="window.location='{{ route('produksi.index') }}'">Batal</x-secondary-button>
                            <x-primary-button>{{ __('Request ke Gudang') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
