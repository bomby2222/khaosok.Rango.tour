<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteMap extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'title',
        'slug',
        'description',
        'route_color',
        'center_lat',
        'center_lng',
        'zoom_level',
        'waypoints',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'waypoints' => 'array',
        'status' => 'boolean',
        'center_lat' => 'float',
        'center_lng' => 'float',
        'zoom_level' => 'integer',
        'sort_order' => 'integer',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}