<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrackingRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id',
        'search_code',
        'is_found',
        'source_page',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'is_found' => 'boolean',
    ];

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }
}
