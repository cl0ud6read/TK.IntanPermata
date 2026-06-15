<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$produksi = App\Models\Produksi::find(14);
if ($produksi) {
    echo "Produksi status: " . $produksi->status . "\n";
    $allSupplied = $produksi->detailProduksi->every(function($d) {
        return $d->status === 'supplied' || $d->status === 'approved';
    });
    echo "All supplied: " . ($allSupplied ? 'true' : 'false') . "\n";
} else {
    echo "Produksi not found\n";
}
