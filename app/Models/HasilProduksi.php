<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilProduksi extends Model
{
    use HasFactory;

    protected $table = 'hasil_produksis';

    protected $fillable = [
        'produksi_id',
        'product_id',
        'quantity_produced',
        'quantity_defect',
        'status',
        'approved_by',
        'approved_at',
    ];

    public function produksi()
    {
        return $this->belongsTo(Produksi::class, 'produksi_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
