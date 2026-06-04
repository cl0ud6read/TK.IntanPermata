<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->uuid('batch_id')->index();
            $table->string('reference_type');
            $table->unsignedBigInteger('reference_id');
            $table->string('action'); // purchase_approval, production_usage, sales_deduction, manual_adjustment
            $table->string('item_type'); // bahan_baku or product
            $table->unsignedBigInteger('item_id');
            $table->string('type'); // in, out
            $table->integer('quantity'); // CHECK > 0
            $table->integer('stock_before');
            $table->integer('stock_after'); // CHECK >= 0
            $table->timestamp('movement_date')->useCurrent()->index();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            // Composite Indexes
            $table->index(['item_type', 'item_id']);
            $table->index(['reference_type', 'reference_id']);
        });

        // Add CHECK constraints
        DB::statement('ALTER TABLE stock_movements ADD CONSTRAINT stock_movements_quantity_check CHECK (quantity > 0)');
        DB::statement('ALTER TABLE stock_movements ADD CONSTRAINT stock_movements_stock_after_check CHECK (stock_after >= 0)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE stock_movements DROP CONSTRAINT IF EXISTS stock_movements_quantity_check');
        DB::statement('ALTER TABLE stock_movements DROP CONSTRAINT IF EXISTS stock_movements_stock_after_check');
        
        Schema::dropIfExists('stock_movements');
    }
};
