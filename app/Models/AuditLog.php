<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    public $timestamps = false; // Using custom timestamp column

    protected $fillable = [
        'user_id',
        'action',
        'entity_type',
        'entity_id',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'timestamp',
    ];

    protected $casts = [
        'old_values' => 'json',
        'new_values' => 'json',
        'timestamp' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
