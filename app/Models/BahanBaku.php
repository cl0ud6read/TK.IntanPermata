<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BahanBaku extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bahan_bakus';

    protected $fillable = [
        'category_id',
        'unit_id',
        'sku',
        'name',
        'quantity',
        'min_stock',
        'purchase_price',
        'description',
        'is_below_min_stock',
    ];

    protected $casts = [
        'is_below_min_stock' => 'boolean',
    ];

    // Mutator to ensure SKU is uppercase
    public function setSkuAttribute($value)
    {
        $this->attributes['sku'] = strtoupper($value);
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function unit(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
