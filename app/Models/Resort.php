<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resort extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'prefix',
        'subtitle',
        'image',
        'gallery',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'gallery' => 'array',
        'status' => 'boolean',
    ];
}