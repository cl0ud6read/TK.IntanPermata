<?php

namespace App\Enums;

enum AdjustmentType: string
{
    case CORRECTION = 'correction';
    case DAMAGE = 'damage';
    case LOSS = 'loss';
    case OPNAME_ADJUSTMENT = 'opname_adjustment';

    public function label(): string
    {
        return match($this) {
            self::CORRECTION => 'Koreksi Data',
            self::DAMAGE => 'Barang Rusak',
            self::LOSS => 'Barang Hilang',
            self::OPNAME_ADJUSTMENT => 'Penyesuaian Stok Opname',
        };
    }
}
