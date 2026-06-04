<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produksis', function (Blueprint $table) {
            $table->id();
            $table->string('production_number')->unique();
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $table->foreignId('bom_id')->constrained('boms')->restrictOnDelete();
            $table->integer('target_quantity');
            $table->string('status')->default('pending'); // Initial state
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('detail_produksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produksi_id')->constrained('produksis')->cascadeOnDelete();
            $table->foreignId('bahan_baku_id')->constrained('bahan_bakus')->restrictOnDelete();
            $table->integer('quantity_requested');
            $table->integer('quantity_approved')->default(0);
            $table->string('status')->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });

        Schema::create('hasil_produksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produksi_id')->constrained('produksis')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $table->integer('quantity_produced')->default(0);
            $table->integer('quantity_defect')->default(0);
            $table->string('status')->default('pending_gudang');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_produksis');
        Schema::dropIfExists('detail_produksis');
        Schema::dropIfExists('produksis');
    }
};
