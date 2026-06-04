<?php

namespace App\Services;

use App\Models\BahanBaku;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Str;

class StockService
{
    /**
     * Process a stock movement centrally.
     *
     * @param string $batchId
     * @param string $referenceType (e.g. 'App\Models\Purchase')
     * @param int $referenceId
     * @param string $action (e.g. 'purchase_approval', 'production_usage')
     * @param string $itemType ('bahan_baku' or 'product')
     * @param int $itemId
     * @param string $movementType ('in' or 'out')
     * @param int $quantity (must be > 0)
     * @param string|null $notes
     * @param int|null $userId
     * @return StockMovement
     * @throws Exception
     */
    public function processMovement(
        string $batchId,
        string $referenceType,
        int $referenceId,
        string $action,
        string $itemType,
        int $itemId,
        string $movementType,
        int $quantity,
        ?string $notes = null,
        ?int $userId = null
    ): StockMovement {
        if ($quantity <= 0) {
            throw new Exception("Quantity must be greater than 0.");
        }

        if (!in_array($itemType, ['bahan_baku', 'product'])) {
            throw new Exception("Invalid item type.");
        }

        // Check idempotency: Have we already processed this exact action for this reference?
        $existingMovement = StockMovement::where('reference_type', $referenceType)
            ->where('reference_id', $referenceId)
            ->where('action', $action)
            ->where('item_type', $itemType)
            ->where('item_id', $itemId)
            ->where('type', $movementType)
            ->where('quantity', $quantity)
            ->first();

        if ($existingMovement) {
            // Idempotent return to prevent double processing
            return $existingMovement;
        }

        try {
            return DB::transaction(function () use (
                $batchId, $referenceType, $referenceId, $action, $itemType, $itemId, $movementType, $quantity, $notes, $userId
            ) {
                // Pessimistic Locking
                $itemClass = $itemType === 'bahan_baku' ? BahanBaku::class : Product::class;
                $item = $itemClass::lockForUpdate()->findOrFail($itemId);

                $stockBefore = $item->quantity;
                $stockAfter = $movementType === 'in' ? $stockBefore + $quantity : $stockBefore - $quantity;

                // Absolute Backend Assertion for Negative Stock
                if ($stockAfter < 0) {
                    throw new Exception("Insufficient stock for {$item->name}. Available: {$stockBefore}, Requested: {$quantity}");
                }

                // Update physical stock
                $item->quantity = $stockAfter;
                
                // Real-time Reorder Alert Toggle
                if ($item->min_stock > 0) {
                    $item->is_below_min_stock = $stockAfter < $item->min_stock;
                }
                
                $item->save();

                // Record into immutable ledger
                $movement = StockMovement::create([
                    'batch_id' => $batchId,
                    'reference_type' => $referenceType,
                    'reference_id' => $referenceId,
                    'action' => $action,
                    'item_type' => $itemType,
                    'item_id' => $itemId,
                    'type' => $movementType,
                    'quantity' => $quantity,
                    'stock_before' => $stockBefore,
                    'stock_after' => $stockAfter,
                    'notes' => $notes,
                    'created_by' => $userId,
                ]);

                return $movement;

            }, 5); // Retry 5 times on deadlock

        } catch (Exception $e) {
            // If it's our logic exception, just throw it
            if (strpos($e->getMessage(), 'Insufficient stock') !== false || strpos($e->getMessage(), 'Quantity must be') !== false) {
                throw $e;
            }
            // Otherwise, it might be a DB retry exhaustion or something else
            \Log::error('Stock processing failed: ' . $e->getMessage(), [
                'reference_id' => $referenceId,
                'action' => $action
            ]);
            throw new Exception("Sistem sedang sibuk memproses antrean stok, silakan coba beberapa saat lagi. Detail: " . $e->getMessage());
        }
    }

    /**
     * Reversal / Compensating Transaction
     */
    public function reverseMovement(StockMovement $originalMovement, ?int $userId = null, ?string $notes = null): StockMovement
    {
        $batchId = (string) Str::uuid();
        $reverseType = $originalMovement->type === 'in' ? 'out' : 'in';
        $reverseAction = $originalMovement->action . '_reversal';
        $reverseNotes = $notes ?? "Reversal of movement ID {$originalMovement->id}";

        return $this->processMovement(
            $batchId,
            $originalMovement->reference_type,
            $originalMovement->reference_id,
            $reverseAction,
            $originalMovement->item_type,
            $originalMovement->item_id,
            $reverseType,
            $originalMovement->quantity,
            $reverseNotes,
            $userId
        );
    }
}
