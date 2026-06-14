<?php
$replacements = [
    "__('Sales')" => "__('Daftar Penjualan')",
    "title=\"Sales\"" => "title=\"Penjualan\"",
    "__('Purchases')" => "__('Daftar Pembelian')",
    "title=\"Purchases\"" => "title=\"Pembelian\"",
    "__('Customers')" => "__('Daftar Pelanggan')",
    "title=\"Customers\"" => "title=\"Pelanggan\"",
    "__('Suppliers')" => "__('Daftar Pemasok')",
    "title=\"Suppliers\"" => "title=\"Pemasok\"",
    "__('Products')" => "__('Daftar Produk')",
    "title=\"Products\"" => "title=\"Produk\"",
    "__('Categories')" => "__('Daftar Kategori')",
    "title=\"Categories\"" => "title=\"Kategori\"",
    "__('Units')" => "__('Daftar Satuan')",
    "title=\"Units\"" => "title=\"Satuan\"",
    "__('Users')" => "__('Daftar Pengguna')",
    "title=\"Users\"" => "title=\"Pengguna\"",
    "__('Finance Transactions')" => "__('Transaksi Keuangan')",
    "title=\"Finance Transactions\"" => "title=\"Transaksi Keuangan\"",
    "__('Finance Categories')" => "__('Kategori Keuangan')",
    "title=\"Finance Categories\"" => "title=\"Kategori Keuangan\"",
    "__('Create New Customer')" => "__('Tambah Pelanggan Baru')"
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
            echo 'Updated Titles: ' . $file->getPathname() . "\n";
        }
    }
}
