<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\FinanceTransaction;
use Illuminate\Support\Facades\DB;

$user = User::where('username', 'inneszahwa')->first();

if (!$user) {
    echo "User not found\n";
    exit;
}

echo "Deleting user: " . $user->name . " (ID: " . $user->id . ")\n";

DB::transaction(function() use ($user) {
    // Purchases
    $purchaseIds = Purchase::where('created_by', $user->id)->pluck('id');
    DB::table('purchase_items')->whereIn('purchase_id', $purchaseIds)->delete();
    $purchases = Purchase::where('created_by', $user->id)->count();
    Purchase::where('created_by', $user->id)->delete();
    echo "Deleted $purchases purchases and their items\n";
    
    // Sales
    $saleIds = Sale::where('created_by', $user->id)->pluck('id');
    DB::table('sale_items')->whereIn('sale_id', $saleIds)->delete();
    $sales = Sale::where('created_by', $user->id)->count();
    Sale::where('created_by', $user->id)->delete();
    echo "Deleted $sales sales and their items\n";

    // Finance Transactions
    $finances = FinanceTransaction::where('created_by', $user->id)->count();
    FinanceTransaction::where('created_by', $user->id)->delete();
    echo "Deleted $finances finance transactions\n";

    $user->delete();
    echo "User deleted successfully.\n";
});

