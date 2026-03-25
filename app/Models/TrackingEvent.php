<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_uid',
        'tracking_number',
        'event_type',
        'status',
        'occurred_at',
        'latitude',
        'longitude',
        'notes',
        'source_system',
        'received_at',
    ];

    protected $casts = [
        'occurred_at' => 'datetime',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'received_at' => 'datetime',
    ];
}
