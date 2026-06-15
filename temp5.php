<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$sales = App\Models\Sale::whereIn('id', [23, 24])->get();
foreach ($sales as $sale) {
    echo "Sale ID: " . $sale->id . "\n";
    $sale->status = 'pending';
    $sale->save();
    
    // Delete associated finance transactions
    $deleted = App\Models\FinanceTransaction::where('reference_id', $sale->id)
        ->where('reference_type', App\Models\Sale::class)
        ->delete();
    echo "Deleted $deleted finance transactions.\n";
}
