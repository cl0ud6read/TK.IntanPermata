<?php

$dir = 'c:\laravel10\inventory-management-system-main\resources\views\livewire';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

$replacements = [
    // Common
    "__('Cancel')" => "__('Batal')",
    "__('Save Changes')" => "__('Simpan Perubahan')",
    "label=\"Name\"" => "label=\"Nama\"",
    "label=\"Phone\"" => "label=\"Telepon\"",
    "__('Address')" => "__('Alamat')",
    "placeholder=\"Full Address\"" => "placeholder=\"Alamat Lengkap\"",
    "__('Notes')" => "__('Catatan')",
    "placeholder=\"Additional notes...\"" => "placeholder=\"Catatan Tambahan...\"",
    "__('Description')" => "__('Deskripsi')",
    "label=\"Description\"" => "label=\"Deskripsi\"",
    "placeholder=\"Optional description...\"" => "placeholder=\"Deskripsi opsional...\"",
    
    // Customers
    "__('Ubah Pelanggan')" => "__('Ubah Pelanggan')", // already correct
    "__('Tambah Pelanggan')" => "__('Tambah Pelanggan')",
    "__('Make changes to the customer details here. Click update when you\'re done.')" => "__('Ubah detail pelanggan di sini. Klik simpan perubahan jika sudah selesai.')",
    "__('Add a new customer to your records.')" => "__('Tambahkan data pelanggan baru.')",
    "placeholder=\"Customer Name\"" => "placeholder=\"Nama Pelanggan\"",
    
    // Suppliers
    "__('Ubah Pemasok')" => "__('Ubah Pemasok')",
    "__('Tambah Pemasok')" => "__('Tambah Pemasok')",
    "__('Make changes to the supplier details here. Click update when you\'re done.')" => "__('Ubah detail pemasok di sini. Klik simpan perubahan jika sudah selesai.')",
    "__('Add a new supplier to your records.')" => "__('Tambahkan data pemasok baru.')",
    "placeholder=\"Supplier Name\"" => "placeholder=\"Nama Pemasok\"",
    
    // Finance Categories
    "__('Edit Finance Category')" => "__('Ubah Kategori Keuangan')",
    "__('Create Finance Category')" => "__('Tambah Kategori Keuangan')",
    "__('Make changes to the category details here. Click update when you\'re done.')" => "__('Ubah detail kategori di sini. Klik simpan perubahan jika sudah selesai.')",
    "__('Add a new category for your financial transactions.')" => "__('Tambahkan kategori baru untuk transaksi keuangan.')",
    "label=\"Category Name\"" => "label=\"Nama Kategori\"",
    "placeholder=\"e.g., Office Supplies, Salary\"" => "placeholder=\"Cth: Gaji, Operasional...\"",
    "__('Type')" => "__('Tipe')",
    "Income" => "Pemasukan",
    "Expense" => "Pengeluaran",
    
    // Finance Transactions
    "__('Edit Transaction')" => "__('Ubah Transaksi')",
    "__('Record Transaction')" => "__('Catat Transaksi')",
    "__('Make changes to the transaction details here. Click update when you\'re done.')" => "__('Ubah detail transaksi di sini. Klik simpan perubahan jika sudah selesai.')",
    "__('Add a new financial transaction to your records.')" => "__('Tambahkan catatan transaksi keuangan baru.')",
    "__('Transaction Date')" => "__('Tanggal Transaksi')",
    "__('Category')" => "__('Kategori')",
    "Select Category" => "Pilih Kategori",
    "label=\"Amount\"" => "label=\"Nominal\"",
    "placeholder=\"0.00\"" => "placeholder=\"0\"",
    "__('Proof Image (Optional)')" => "__('Bukti Gambar (Opsional)')",
    
    // Products
    "__('Ubah Produk')" => "__('Ubah Produk')",
    "__('Tambah Produk')" => "__('Tambah Produk')",
    "__('Make changes to the product details here. Click update when you\'re done.')" => "__('Ubah detail produk di sini. Klik simpan perubahan jika sudah selesai.')",
    "__('Add a new product to your inventory.')" => "__('Tambahkan data produk baru.')",
    "placeholder=\"Product Name\"" => "placeholder=\"Nama Produk\"",
    "label=\"SKU / Code\"" => "label=\"SKU / Kode\"",
    "label=\"Purchase Price\"" => "label=\"Harga Beli\"",
    "label=\"Selling Price\"" => "label=\"Harga Jual\"",
    "label=\"Minimum Stock\"" => "label=\"Stok Minimum\"",
    "Select Unit" => "Pilih Satuan",
    
    // Categories
    "__('Ubah Kategori')" => "__('Ubah Kategori')",
    "__('Tambah Kategori')" => "__('Tambah Kategori')",
    "__('Add a new category to organize your products.')" => "__('Tambahkan kategori baru untuk mengelompokkan produk.')",
    
    // Units
    "__('Edit Unit')" => "__('Ubah Satuan')",
    "__('Create Unit')" => "__('Tambah Satuan')",
    "__('Make changes to the unit details here. Click update when you\'re done.')" => "__('Ubah detail satuan di sini. Klik simpan perubahan jika sudah selesai.')",
    "__('Add a new unit of measurement for your products.')" => "__('Tambahkan satuan ukur baru untuk produk Anda.')",
    "label=\"Unit Name\"" => "label=\"Nama Satuan\"",
    "placeholder=\"e.g., Kilogram, Piece, Box\"" => "placeholder=\"Cth: Kilogram, Pcs, Box\"",
    "label=\"Symbol\"" => "label=\"Simbol\"",
    "placeholder=\"e.g., kg, pcs, box\"" => "placeholder=\"Cth: kg, pcs, box\"",
];

foreach ($iterator as $file) {
    if ($file->isFile() && strpos($file->getFilename(), 'form.blade.php') !== false) {
        $content = file_get_contents($file->getPathname());
        foreach ($replacements as $search => $replace) {
            $content = str_replace($search, $replace, $content);
        }
        file_put_contents($file->getPathname(), $content);
        echo "Translated: " . $file->getFilename() . "\n";
    }
}
echo "Done.\n";
