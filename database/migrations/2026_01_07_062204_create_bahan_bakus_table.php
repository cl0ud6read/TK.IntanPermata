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
        Schema::create('bahan_bakus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained()->nullOnDelete();
            $table->string('sku')->unique(); // Collation handles case-insensitivity in MySQL by default
            $table->string('name');
            $table->integer('quantity')->default(0);
            $table->integer('min_stock')->default(0);
            $table->integer('purchase_price')->default(0);
            $table->text('description')->nullable();
            $table->boolean('is_below_min_stock')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        // Add CHECK constraint manually
        DB::statement('ALTER TABLE bahan_bakus ADD CONSTRAINT bahan_bakus_quantity_check CHECK (quantity >= 0)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan_bakus');
    }
};
