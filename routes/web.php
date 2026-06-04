<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinanceReportController;

Route::middleware(['auth', 'verified'])->group(function () {
    // =========================================================================
    // Dashboard & Profile
    // =========================================================================
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::view('profile', 'profile.index')->name('profile.index');

    // =========================================================================
    // Master Data
    // =========================================================================
    Route::prefix('master')->group(function () {
        Route::view('customers', 'customers.index')->name('customers.index');
        Route::view('suppliers', 'suppliers.index')->name('suppliers.index');
        Route::view('categories', 'categories.index')->name('categories.index');
        Route::view('units', 'units.index')->name('units.index');
        Route::view('products', 'products.index')->name('products.index');
    });

    // =========================================================================
    // Transactions
    // =========================================================================

    // Purchases
    Route::resource('purchases', PurchaseController::class);
    Route::prefix('purchases/{purchase}')->name('purchases.')->controller(PurchaseController::class)->group(function () {
        Route::patch('ordered', 'markOrdered')->name('mark-ordered');
        Route::patch('received', 'markReceived')->name('mark-received');
        Route::patch('paid', 'markPaid')->name('mark-paid');
        Route::patch('cancel', 'cancel')->name('cancel');
        Route::patch('restore-draft', 'restoreToDraft')->name('restore-draft');
    });

    // Sales
    Route::resource('sales', SalesController::class)->except(['edit', 'update']);
    Route::prefix('sales/{sale}')->name('sales.')->controller(SalesController::class)->group(function () {
        Route::get('print', 'print')->name('print');
        Route::patch('complete', 'complete')->name('complete');
        Route::patch('restore', 'restore')->name('restore');
    });

    // =========================================================================
    // Finance
    // =========================================================================
    Route::prefix('finance')->name('finance.')->group(function () {
        Route::view('categories', 'finance-categories.index')->name('categories.index');
        Route::view('transactions', 'finance-transactions.index')->name('transactions.index');
        Route::get('transactions/print/{printId}', [FinanceReportController::class, 'print'])->name('transactions.print');
    });

    // =========================================================================
    // Settings & Users
    // =========================================================================
    Route::middleware(['role:admin'])->group(function () {
        Route::view('users', 'users.index')->name('users.index');
        Route::view('settings', 'settings.index')->name('settings.index');
    });

    // =========================================================================
    // Mini ERP Modules
    // =========================================================================
    Route::resource('bahan-baku', \App\Http\Controllers\BahanBakuController::class);
    
    Route::resource('bom', \App\Http\Controllers\BOMController::class)->except(['edit', 'update']);
    
    Route::resource('produksi', \App\Http\Controllers\ProduksiController::class)->except(['edit', 'update', 'destroy']);
    Route::patch('produksi/{produksi}/status', [\App\Http\Controllers\ProduksiController::class, 'updateStatus'])->name('produksi.update_status');

    Route::prefix('gudang')->name('gudang.')->group(function () {
        Route::get('masuk/purchase', [\App\Http\Controllers\GudangMasukController::class, 'purchaseIndex'])->name('masuk.purchase');
        Route::patch('masuk/purchase/{purchase}/approve', [\App\Http\Controllers\GudangMasukController::class, 'approvePurchase'])->name('masuk.purchase.approve');
        
        Route::get('masuk/produksi', [\App\Http\Controllers\GudangMasukController::class, 'hasilProduksiIndex'])->name('masuk.produksi');
        Route::patch('masuk/produksi/{hasilProduksi}/approve', [\App\Http\Controllers\GudangMasukController::class, 'approveHasilProduksi'])->name('masuk.produksi.approve');

        Route::get('keluar/produksi', [\App\Http\Controllers\GudangKeluarController::class, 'detailProduksiIndex'])->name('keluar.produksi');
        Route::patch('keluar/produksi/{detailProduksi}/approve', [\App\Http\Controllers\GudangKeluarController::class, 'approveDetailProduksi'])->name('keluar.produksi.approve');

        Route::get('keluar/sale', [\App\Http\Controllers\GudangKeluarController::class, 'saleIndex'])->name('keluar.sale');
        Route::patch('keluar/sale/{sale}/approve', [\App\Http\Controllers\GudangKeluarController::class, 'approveSale'])->name('keluar.sale.approve');

        Route::get('adjustment/create', [\App\Http\Controllers\StockAdjustmentController::class, 'create'])->name('adjustment.create');
        Route::post('adjustment', [\App\Http\Controllers\StockAdjustmentController::class, 'store'])->name('adjustment.store');
    });

    // =========================================================================
    // Internal APIs (AJAX)
    // =========================================================================
    Route::prefix('ajax')->name('ajax.')->group(function () {
        Route::post('products', [\App\Http\Controllers\Api\ProductController::class, 'search'])->name('products.search');
        Route::post('suppliers', [\App\Http\Controllers\Api\SupplierController::class, 'search'])->name('suppliers.search');
        Route::post('customers', [\App\Http\Controllers\Api\CustomerController::class, 'search'])->name('customers.search');
        Route::post('customers/store', [\App\Http\Controllers\Api\CustomerController::class, 'store'])->name('customers.store');
        Route::post('categories', [\App\Http\Controllers\Api\CategoryController::class, 'search'])->name('categories.search');
        Route::post('units', [\App\Http\Controllers\Api\UnitController::class, 'search'])->name('units.search');
        Route::post('users', [\App\Http\Controllers\Api\UserController::class, 'search'])->name('users.search');
        Route::post('finance-categories', [\App\Http\Controllers\Api\FinanceCategoryController::class, 'search'])->name('finance-categories.search');
    });
});

require __DIR__.'/auth.php';
