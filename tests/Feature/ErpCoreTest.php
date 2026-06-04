<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\BahanBaku;
use App\Models\Bom;
use App\Models\Produksi;
use App\Models\Category;
use App\Models\Unit;
use App\Services\StockService;
use App\Models\StockMovement;
use Illuminate\Support\Str;

class ErpCoreTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Mock the user
        $this->user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($this->user);

        // Required master data
        $this->category = Category::create(['name' => 'Raw Material', 'slug' => 'raw-material']);
        $this->unit = Unit::create(['name' => 'Kilogram', 'short_name' => 'KG']);
    }

    public function test_stock_deduction_and_ledger()
    {
        $bahanBaku = BahanBaku::create([
            'category_id' => $this->category->id,
            'unit_id' => $this->unit->id,
            'sku' => 'BB-001',
            'name' => 'Tanah Liat',
            'quantity' => 100,
            'min_stock' => 10,
            'purchase_price' => 5000,
        ]);

        $stockService = new StockService();
        $batchId = (string) Str::uuid();

        // Perform deduction
        $movement = $stockService->processMovement(
            $batchId,
            'App\Models\Produksi',
            1,
            'production_usage',
            'bahan_baku',
            $bahanBaku->id,
            'out',
            20,
            'Test deduction'
        );

        $bahanBaku->refresh();

        $this->assertEquals(80, $bahanBaku->quantity);
        $this->assertEquals(100, $movement->stock_before);
        $this->assertEquals(80, $movement->stock_after);
        $this->assertEquals('out', $movement->type);
    }

    public function test_stock_reversal()
    {
        $bahanBaku = BahanBaku::create([
            'category_id' => $this->category->id,
            'unit_id' => $this->unit->id,
            'sku' => 'BB-002',
            'name' => 'Pasir',
            'quantity' => 100,
            'min_stock' => 10,
            'purchase_price' => 2000,
        ]);

        $stockService = new StockService();
        $batchId = (string) Str::uuid();

        // Original movement (in)
        $original = $stockService->processMovement(
            $batchId,
            'App\Models\Purchase',
            1,
            'purchase_approval',
            'bahan_baku',
            $bahanBaku->id,
            'in',
            50,
            'Incoming'
        );

        $this->assertEquals(150, $bahanBaku->fresh()->quantity);

        // Reverse it
        $reversal = $stockService->reverseMovement($original);

        $this->assertEquals(100, $bahanBaku->fresh()->quantity);
        $this->assertEquals('out', $reversal->type);
        $this->assertEquals(150, $reversal->stock_before);
        $this->assertEquals(100, $reversal->stock_after);
        $this->assertEquals('purchase_approval_reversal', $reversal->action);
    }

    public function test_terminal_state_immutability()
    {
        $product = Product::create([
            'category_id' => $this->category->id,
            'unit_id' => $this->unit->id,
            'sku' => 'PRD-001',
            'name' => 'Keramik A',
            'purchase_price' => 10000,
            'selling_price' => 20000,
            'quantity' => 0,
            'min_stock' => 5,
        ]);

        $bom = Bom::create([
            'product_id' => $product->id,
            'name' => 'BOM Keramik A',
            'is_active' => true,
        ]);

        $produksi = Produksi::create([
            'production_number' => 'PRD-TEST',
            'product_id' => $product->id,
            'bom_id' => $bom->id,
            'target_quantity' => 100,
            'status' => 'completed', // Terminal state
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Cannot modify status, product_id, or target_quantity of a production that is already in a terminal state (completed).');

        // Attempting to change target quantity should throw exception via Observer
        $produksi->target_quantity = 200;
        $produksi->save();
    }
}
