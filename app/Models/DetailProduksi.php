<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailProduksi extends Model
{
    use HasFactory;

    protected $table = 'detail_produksis';

    protected $fillable = [
        'produksi_id',
        'bahan_baku_id',
        'quantity_requested',
        'quantity_approved',
        'status',
        'approved_by',
        'approved_at',
    ];

    public function produksi()
    {
        return $this->belongsTo(Produksi::class, 'produksi_id');
    }

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class)->withTrashed();
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
