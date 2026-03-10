<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'route',
        'cargo_type',
        'comment',
        'consent',
        'source_page',
        'status',
    ];

    protected $casts = [
        'consent' => 'boolean',
    ];
}
