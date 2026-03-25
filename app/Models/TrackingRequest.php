<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'search_code',
        'is_found',
        'source_page',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'is_found' => 'boolean',
    ];
}
