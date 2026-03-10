<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShipmentStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id',
        'title',
        'place',
        'happened_at',
        'is_done',
        'sort_order',
    ];

    protected $casts = [
        'happened_at' => 'datetime',
        'is_done' => 'boolean',
    ];

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }
}
