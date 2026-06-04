<x-app-layout title="Buat BOM Baru">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-foreground leading-tight">
                {{ __('Buat Bill of Materials (BOM) Baru') }}
            </h2>
            <a href="{{ route('bom.index') }}" class="text-sm text-muted-foreground hover:text-foreground">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12" x-data="bomForm()">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-card shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('bom.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <!-- Product -->
                            <div>
                                <x-input-label for="product_id" :value="__('Produk Akhir (Barang Jadi)')" />
                                <select id="product_id" name="product_id" class="border-input bg-background text-foreground focus:border-primary focus:ring-primary rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }} ({{ $product->sku }})</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
                            </div>

                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Nama BOM (Varian/Resep)')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" placeholder="Misal: Resep Standar A" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Notes -->
                            <div class="md:col-span-2">
                                <x-input-label for="notes" :value="__('Catatan/Deskripsi')" />
                                <textarea id="notes" name="notes" class="border-input bg-background text-foreground focus:border-primary focus:ring-primary rounded-md shadow-sm block mt-1 w-full" rows="2">{{ old('notes') }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                        </div>

                        <div class="border-t border-border pt-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-foreground">Komposisi Bahan Baku</h3>
                                <button type="button" @click="addItem" class="inline-flex items-center px-3 py-1 bg-secondary border border-transparent rounded-md font-semibold text-xs text-secondary-foreground uppercase tracking-widest hover:bg-secondary/80 focus:bg-secondary/80 active:bg-secondary/80 focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-offset-2 transition ease-in-out duration-150">
                                    <x-heroicon-o-plus class="w-4 h-4 mr-1" /> Tambah Bahan
                                </button>
                            </div>

                            <table class="w-full text-sm text-left mb-4">
                                <thead class="text-xs text-muted-foreground uppercase bg-muted/50 border-b border-border">
                                    <tr>
                                        <th class="px-4 py-2">Bahan Baku</th>
                                        <th class="px-4 py-2 w-32">Kuantitas</th>
                                        <th class="px-4 py-2 w-16">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(item, index) in items" :key="index">
                                        <tr class="border-b border-border">
                                            <td class="px-4 py-2">
                                                <select x-model="item.bahan_baku_id" :name="'bahan_baku_id['+index+']'" class="border-input bg-background text-foreground focus:border-primary focus:ring-primary rounded-md shadow-sm w-full text-sm" required>
                                                    <option value="">-- Pilih Bahan --</option>
                                                    @foreach($bahanBakus as $bb)
                                                        <option value="{{ $bb->id }}">{{ $bb->name }} ({{ $bb->sku }}) - {{ $bb->unit->symbol ?? '' }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="number" x-model="item.quantity" :name="'quantity['+index+']'" min="1" class="border-input bg-background text-foreground focus:border-primary focus:ring-primary rounded-md shadow-sm w-full text-sm" required>
                                            </td>
                                            <td class="px-4 py-2 text-center">
                                                <button type="button" @click="removeItem(index)" class="text-red-500 hover:text-red-700 p-1">
                                                    <x-heroicon-o-trash class="w-5 h-5" />
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                            
                            <!-- Validations -->
                            <template x-if="items.length === 0">
                                <p class="text-red-500 text-sm mt-2">Minimal harus ada 1 bahan baku.</p>
                            </template>
                            @error('bahan_baku_id')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6 gap-4">
                            <x-secondary-button type="button" onclick="window.location='{{ route('bom.index') }}'">Batal</x-secondary-button>
                            <x-primary-button x-bind:disabled="items.length === 0">{{ __('Simpan BOM') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function bomForm() {
            return {
                items: [
                    { bahan_baku_id: '', quantity: 1 }
                ],
                addItem() {
                    this.items.push({ bahan_baku_id: '', quantity: 1 });
                },
                removeItem(index) {
                    if(this.items.length > 1) {
                        this.items.splice(index, 1);
                    } else {
                        alert('Minimal harus ada 1 bahan baku.');
                    }
                }
            }
        }
    </script>
</x-app-layout>
