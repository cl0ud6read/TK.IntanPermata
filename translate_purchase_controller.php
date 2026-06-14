<?php
$replacements = [
    "'Purchase created successfully.'" => "'Pembelian berhasil dibuat.'",
    "'Error creating purchase: '" => "'Gagal membuat pembelian: '",
    "'Purchase updated successfully.'" => "'Data pembelian berhasil diperbarui.'",
    "'Error updating purchase: '" => "'Gagal memperbarui pembelian: '",
    "'Purchase deleted successfully.'" => "'Pembelian berhasil dihapus.'",
    "'Error deleting purchase: '" => "'Gagal menghapus pembelian: '",
    "'Purchase marked as ordered.'" => "'Pembelian ditandai sebagai dipesan.'",
    "'Error marking as ordered: '" => "'Gagal menandai pesanan: '",
    "'Purchase received and stock updated.'" => "'Barang diterima dan stok telah diperbarui.'",
    "'Error receiving purchase: '" => "'Gagal memproses penerimaan: '",
    "'Purchase order cancelled.'" => "'Pesanan pembelian berhasil dibatalkan.'",
    "'Error cancelling purchase: '" => "'Gagal membatalkan pesanan: '",
    "'Purchase marked as paid.'" => "'Pembelian ditandai Lunas (Dibayar).'",
    "'Error marking as paid: '" => "'Gagal menandai pembayaran: '",
    "'Purchase restored to draft.'" => "'Pembelian dikembalikan ke status draf.'",
    "'Error restoring purchase: '" => "'Gagal mengembalikan status pembelian: '"
];

$file = 'c:\laravel10\inventory-management-system-main\app\Http\Controllers\PurchaseController.php';
$content = file_get_contents($file);
foreach ($replacements as $search => $replace) {
    $content = str_replace($search, $replace, $content);
}
file_put_contents($file, $content);
echo "Translated PurchaseController UI notifications.\n";
