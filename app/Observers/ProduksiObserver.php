<?php

namespace App\Observers;

use App\Models\Produksi;
use Exception;

class ProduksiObserver
{
    /**
     * Handle the Produksi "saving" event.
     */
    public function saving(Produksi $produksi): void
    {
        // Check if the record already exists (it's an update, not a create)
        if ($produksi->exists) {
            $originalStatus = $produksi->getOriginal('status');

            // If it was already in a terminal state
            if (in_array($originalStatus, Produksi::TERMINAL_STATES)) {
                
                // If they are trying to change status, product_id, or target_quantity
                if ($produksi->isDirty('status') || $produksi->isDirty('product_id') || $produksi->isDirty('target_quantity')) {
                    throw new Exception("Cannot modify status, product_id, or target_quantity of a production that is already in a terminal state ({$originalStatus}).");
                }
            }
            
            // If they are trying to change status, ensure it's a valid transition
            if ($produksi->isDirty('status')) {
                $newStatus = $produksi->status;
                $validTransitions = Produksi::VALID_TRANSITIONS[$originalStatus] ?? [];
                
                if (!in_array($newStatus, $validTransitions)) {
                    throw new Exception("Invalid status transition from {$originalStatus} to {$newStatus}.");
                }
            }
        }
    }
}
