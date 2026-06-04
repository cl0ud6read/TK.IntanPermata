<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BomItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'bom_id',
        'bahan_baku_id',
        'quantity',
    ];

    public function bom()
    {
        return $this->belongsTo(Bom::class);
    }

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class)->withTrashed();
    }
}
