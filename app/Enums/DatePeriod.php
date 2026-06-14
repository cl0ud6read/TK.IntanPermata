<?php

namespace App\Enums;

enum DatePeriod: string
{
    case TODAY = 'today';
    case YESTERDAY = 'yesterday';
    case THIS_WEEK = 'this_week';
    case THIS_MONTH = 'this_month';
    case LAST_MONTH = 'last_month';
    case CUSTOM = 'custom';

    public function label(): string
    {
        return match($this) {
            self::TODAY => 'Hari Ini',
            self::YESTERDAY => 'Kemarin',
            self::THIS_WEEK => 'Minggu Ini',
            self::THIS_MONTH => 'Bulan Ini',
            self::LAST_MONTH => 'Bulan Lalu',
            self::CUSTOM => 'Periode Kustom',
        };
    }
}
