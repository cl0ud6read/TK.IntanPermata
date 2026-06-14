<?php
$replacements = [
    "__('Supplier')" => "__('Pemasok')",
    "placeholder: 'Select Supplier...'" => "placeholder: 'Pilih Pemasok...'",
    "__('Invoice Number (Optional)')" => "__('Nomor Faktur (Opsional)')",
    "placeholder=\"Leave empty for drafts\"" => "placeholder=\"Kosongkan untuk draf\"",
    "__('Proof of Receipt')" => "__('Bukti Terima')",
    "__('Purchase Date')" => "__('Tanggal Pembelian')",
    "__('Due Date')" => "__('Jatuh Tempo')",
    "'Draft (Default)'" => "'Draf (Default)'",
    "__('Notes')" => "__('Catatan')",
    "placeholder=\"Additional notes...\"" => "placeholder=\"Catatan tambahan...\"",
    "placeholder=\"Search Product to Add...\"" => "placeholder=\"Cari Produk untuk Ditambahkan...\"",
    "placeholder: 'Search Product to Add...'" => "placeholder: 'Cari Produk untuk Ditambahkan...'",
    "Product</th>" => "Produk</th>",
    "Qty</th>" => "Jml</th>",
    "Buy Price</th>" => "Harga Beli</th>",
    "Sell Price</th>" => "Harga Jual</th>",
    "Action</th>" => "Aksi</th>",
    "Low margin" => "Margin rendah",
    "Total Purchase:" => "Total Pembelian:",
    "No items added" => "Belum ada item",
    "Search products above to add to purchase list" => "Cari produk di atas untuk ditambahkan ke daftar",
    "__('Cancel')" => "__('Batal')",
    "'Processing...'" => "'Memproses...'",
    "'Product already exists. Quantity updated.'" => "'Produk sudah ada. Jumlah diperbarui.'",
    "'Product \"' + product.text + '\" added to list.'" => "'Produk \"' + product.text + '\" ditambahkan ke daftar.'"
];

$file = 'c:\laravel10\inventory-management-system-main\resources\views\purchases\form.blade.php';
$content = file_get_contents($file);
foreach ($replacements as $search => $replace) {
    $content = str_replace($search, $replace, $content);
}
file_put_contents($file, $content);
echo "Translated Purchase UI.\n";
