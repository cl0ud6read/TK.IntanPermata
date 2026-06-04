<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'unit_id',
        'sku',
        'name',
        'purchase_price',
        'selling_price',
        'quantity',
        'min_stock',
        'is_below_min_stock',
        'is_active',
        'description',
        'notes',
    ];

    protected $casts = [
        'purchase_price' => 'integer',
        'selling_price' => 'integer',
        'quantity' => 'integer',
        'min_stock' => 'integer',
        'is_active' => 'boolean',
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

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function boms()
    {
        return $this->hasMany(Bom::class);
    }
}
