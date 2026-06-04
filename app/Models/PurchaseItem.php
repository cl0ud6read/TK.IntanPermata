<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'bahan_baku_id',
        'quantity',
        'unit_price',
        'subtotal',
        'selling_price',
    ];

    protected $casts = [
        'purchase_id' => 'integer',
        'bahan_baku_id' => 'integer',
        'quantity' => 'integer',
        'unit_price' => 'integer',
        'subtotal' => 'integer',
        'selling_price' => 'integer',
    ];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function bahanBaku(): BelongsTo
    {
        return $this->belongsTo(BahanBaku::class)->withTrashed();
    }
}
