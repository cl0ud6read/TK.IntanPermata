<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$details = App\Models\DetailProduksi::where('produksi_id', 14)->get(['id', 'bahan_baku_id', 'status'])->toArray();
print_r($details);
