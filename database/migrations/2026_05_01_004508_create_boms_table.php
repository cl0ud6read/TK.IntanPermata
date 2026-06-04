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
        Schema::create('boms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('name');
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('bom_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bom_id')->constrained('boms')->cascadeOnDelete();
            $table->foreignId('bahan_baku_id')->constrained('bahan_bakus')->restrictOnDelete();
            $table->integer('quantity'); // Quantity required for 1 unit of product
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bom_items');
        Schema::dropIfExists('boms');
    }
};
