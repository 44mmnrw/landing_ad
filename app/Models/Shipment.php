<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'route',
        'cargo_type',
        'weight_kg',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'weight_kg' => 'decimal:2',
    ];

    public function statuses(): HasMany
    {
        return $this->hasMany(ShipmentStatus::class);
    }
}
