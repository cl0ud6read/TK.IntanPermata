<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$p = App\Models\Produksi::find(14);
if ($p && $p->status === 'completed' && $p->hasilProduksi()->count() == 0) {
    $p->hasilProduksi()->create([
        'product_id' => $p->product_id,
        'quantity_produced' => $p->target_quantity,
        'quantity_defect' => 0,
        'status' => 'pending_gudang'
    ]);
    echo "Created\n";
} else {
    echo "Not created. Status: " . ($p ? $p->status : 'null') . "\n";
}
