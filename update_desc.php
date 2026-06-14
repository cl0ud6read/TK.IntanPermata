<?php
$transactions = App\Models\FinanceTransaction::all();
foreach($transactions as $t) {
    if (str_starts_with($t->description, 'Sale Inv:')) {
        $t->update(['description' => str_replace('Sale Inv:', 'Nota Penjualan:', $t->description)]);
    }
    if (str_starts_with($t->description, 'Payment for Purchase')) {
        $t->update(['description' => str_replace('Payment for Purchase', 'Pembayaran Pembelian', $t->description)]);
    }
}
echo "Done";
