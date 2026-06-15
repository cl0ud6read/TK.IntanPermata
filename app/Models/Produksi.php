<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produksi extends Model
{
    use HasFactory;

    protected $table = 'produksis';

    public const INITIAL_STATE = 'pending';
    public const TERMINAL_STATES = ['completed', 'failed'];
    public const VALID_TRANSITIONS = [
        'pending'     => ['in_progress', 'failed'],
        'in_progress' => ['completed', 'failed'],
    ];

    protected $fillable = [
        'production_number',
        'product_id',
        'bom_id',
        'target_quantity',
        'status',
        'start_date',
        'end_date',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Mutator to ensure production_number is uppercase
    public function setProductionNumberAttribute($value)
    {
        $this->attributes['production_number'] = strtoupper($value);
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function bom()
    {
        return $this->belongsTo(Bom::class)->withTrashed();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function detailProduksi()
    {
        return $this->hasMany(DetailProduksi::class, 'produksi_id');
    }

    public function hasilProduksi()
    {
        return $this->hasMany(HasilProduksi::class, 'produksi_id');
    }
}
