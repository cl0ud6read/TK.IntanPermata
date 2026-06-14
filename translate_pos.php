<?php
$replacements = [
    "Search Products (Name or SKU)" => "Cari Produk (Nama atau SKU)",
    "Search Customer" => "Cari Pelanggan",
    "Customer" => "Pelanggan", // This might be risky, but let's be careful.
    "Payment Details" => "Detail Pembayaran",
    "+ New (F4)" => "+ Baru (F4)",
    "Subtotal" => "Subtotal",
    "Discount (Global)" => "Diskon (Global)",
    "Total Discount" => "Total Diskon",
    "Payment Method" => "Metode Pembayaran",
    "CASH" => "TUNAI",
    "TRANSFER" => "TRANSFER",
    "Cash Received" => "Tunai Diterima",
    "EXACT" => "PAS",
    "Transaction Notes / Address..." => "Catatan Transaksi / Alamat...",
    "CANCEL" => "BATAL",
    "PAY (F3)" => "BAYAR (F3)",
    "Processing..." => "Memproses...",
    "Payment Confirmation" => "Konfirmasi Pembayaran",
    "Please review transaction details before processing." => "Harap periksa detail transaksi sebelum memproses.",
    "Total Items" => "Total Item",
    "Extra Discount (Global)" => "Diskon Tambahan (Global)",
    "Total Bill" => "Total Tagihan",
    "Change" => "Kembalian",
    "Sale Status" => "Status Penjualan",
    "COMPLETED" => "SELESAI",
    "PENDING" => "TERTUNDA"
];

$file = 'c:\laravel10\inventory-management-system-main\resources\views\sales\create.blade.php';
$content = file_get_contents($file);
foreach ($replacements as $search => $replace) {
    $content = str_replace($search, $replace, $content);
}
file_put_contents($file, $content);
echo "Translated POS UI.\n";
