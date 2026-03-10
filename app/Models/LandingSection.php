<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LandingSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'subtitle',
        'background_image',
        'meta',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'meta' => 'array',
        'is_active' => 'boolean',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(LandingSectionItem::class, 'section_id');
    }
}
