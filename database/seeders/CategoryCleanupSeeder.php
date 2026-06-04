<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\BahanBaku;
use App\Models\Product;
use Illuminate\Support\Str;

class CategoryCleanupSeeder extends Seeder
{
    public function run()
    {
        // 1. Create proper ceramic categories
        $catBarangJadi = Category::firstOrCreate(
            ['slug' => Str::slug('Keramik Jadi')],
            ['name' => 'Keramik Jadi', 'description' => 'Produk barang jadi berupa keramik siap jual.']
        );
        $catTanahLiat = Category::firstOrCreate(
            ['slug' => Str::slug('Tanah Liat')],
            ['name' => 'Tanah Liat', 'description' => 'Bahan baku utama berupa tanah liat/clay.']
        );
        $catPewarna = Category::firstOrCreate(
            ['slug' => Str::slug('Glasir & Pewarna')],
            ['name' => 'Glasir & Pewarna', 'description' => 'Bahan pelapis, pewarna, dan glasir keramik.']
        );

        // 2. Re-assign existing Products to 'Keramik Jadi'
        Product::query()->update(['category_id' => $catBarangJadi->id]);

        // 3. Re-assign Bahan Baku
        // Tanah liat
        BahanBaku::where('name', 'like', '%Tanah Liat%')->update(['category_id' => $catTanahLiat->id]);
        
        // Pewarna dan Glasir
        BahanBaku::where('name', 'like', '%Pewarna%')->orWhere('name', 'like', '%Glasir%')->update(['category_id' => $catPewarna->id]);

        // Fallback for any other BahanBaku
        BahanBaku::whereNotIn('category_id', [$catTanahLiat->id, $catPewarna->id, $catBarangJadi->id])
                 ->update(['category_id' => $catTanahLiat->id]);

        // 4. Delete the old Toko Bangunan categories
        $oldCategories = [
            'Material Dasar',
            'Kayu & Atap',
            'Cat & Finishing',
            'Lantai & Dinding',
            'Pipa & Listrik',
            'Paku & Alat',
            'General'
        ];

        Category::whereIn('name', $oldCategories)->delete();

        echo "Categories cleaned up successfully!\n";
    }
}
