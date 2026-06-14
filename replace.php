<?php
$replacements = [
    'Create User' => 'Tambah Pengguna',
    'Create Unit' => 'Tambah Satuan',
    'Create Supplier' => 'Tambah Pemasok',
    'Create Sale' => 'Buat Penjualan',
    'Create Purchase' => 'Buat Pembelian',
    'Create Product' => 'Tambah Produk',
    'Create Transaction' => 'Tambah Transaksi',
    'Create Category' => 'Tambah Kategori',
    'Create Finance Category' => 'Tambah Kategori Keuangan',
    'Create Customer' => 'Tambah Pelanggan',
    'Edit User' => 'Ubah Pengguna',
    'Edit Unit' => 'Ubah Satuan',
    'Edit Supplier' => 'Ubah Pemasok',
    'Edit Sale' => 'Ubah Penjualan',
    'Edit Purchase' => 'Ubah Pembelian',
    'Edit Product' => 'Ubah Produk',
    'Edit Transaction' => 'Ubah Transaksi',
    'Edit Category' => 'Ubah Kategori',
    'Edit Finance Category' => 'Ubah Kategori Keuangan',
    'Edit Customer' => 'Ubah Pelanggan'
];

$dir = new RecursiveDirectoryIterator('c:\laravel10\inventory-management-system-main\resources\views');
$ite = new RecursiveIteratorIterator($dir);
foreach ($ite as $file) {
    if ($file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        $changed = false;
        foreach ($replacements as $search => $replace) {
            if (strpos($content, $search) !== false) {
                $content = str_replace($search, $replace, $content);
                $changed = true;
            }
        }
        if ($changed) {
            file_put_contents($file->getPathname(), $content);
            echo 'Updated: ' . $file->getPathname() . "\n";
        }
    }
}
