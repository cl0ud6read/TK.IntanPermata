<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'reference_type',
        'reference_id',
        'action',
        'item_type',
        'item_id',
        'type',
        'quantity',
        'stock_before',
        'stock_after',
        'movement_date',
        'notes',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Polymorphic-like relationship without strict morphTo to avoid hardcoupling
    public function item()
    {
        if ($this->item_type === 'bahan_baku') {
            return $this->belongsTo(BahanBaku::class, 'item_id')->withTrashed();
        } elseif ($this->item_type === 'product') {
            return $this->belongsTo(Product::class, 'item_id')->withTrashed();
        }
        return null;
    }
}
