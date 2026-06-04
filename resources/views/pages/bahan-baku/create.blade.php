<x-app-layout title="Tambah Bahan Baku">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-foreground leading-tight">
                {{ __('Tambah Bahan Baku') }}
            </h2>
            <a href="{{ route('bahan-baku.index') }}" class="text-sm text-muted-foreground hover:text-foreground">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-card shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('bahan-baku.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- SKU -->
                            <div>
                                <x-input-label for="sku" :value="__('SKU')" />
                                <x-text-input id="sku" class="block mt-1 w-full" type="text" name="sku" :value="old('sku')" required autofocus />
                                <x-input-error :messages="$errors->get('sku')" class="mt-2" />
                            </div>

                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Nama Bahan Baku')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Category -->
                            <div>
                                <x-input-label for="category_id" :value="__('Kategori')" />
                                <select id="category_id" name="category_id" class="border-input bg-background text-foreground focus:border-primary focus:ring-primary rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>

                            <!-- Unit -->
                            <div>
                                <x-input-label for="unit_id" :value="__('Satuan')" />
                                <select id="unit_id" name="unit_id" class="border-input bg-background text-foreground focus:border-primary focus:ring-primary rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">-- Pilih Satuan --</option>
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->name }} ({{ $unit->symbol }})</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('unit_id')" class="mt-2" />
                            </div>

                            <!-- Purchase Price -->
                            <div>
                                <x-input-label for="purchase_price" :value="__('Harga Beli Dasar (Rp)')" />
                                <x-text-input id="purchase_price" class="block mt-1 w-full" type="number" min="0" name="purchase_price" :value="old('purchase_price', 0)" required />
                                <x-input-error :messages="$errors->get('purchase_price')" class="mt-2" />
                            </div>

                            <!-- Min Stock -->
                            <div>
                                <x-input-label for="min_stock" :value="__('Minimum Stok (Alert)')" />
                                <x-text-input id="min_stock" class="block mt-1 w-full" type="number" min="0" name="min_stock" :value="old('min_stock', 10)" required />
                                <x-input-error :messages="$errors->get('min_stock')" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <x-input-label for="description" :value="__('Deskripsi/Catatan')" />
                                <textarea id="description" name="description" class="border-input bg-background text-foreground focus:border-primary focus:ring-primary rounded-md shadow-sm block mt-1 w-full" rows="3">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 gap-4">
                            <x-secondary-button type="button" onclick="window.location='{{ route('bahan-baku.index') }}'">Batal</x-secondary-button>
                            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
