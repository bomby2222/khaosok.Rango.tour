<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $guarded = [];

    // 📸 ความสัมพันธ์รูปภาพแกลเลอรี
    public function images()
    {
        return $this->hasMany(TourImage::class);
    }

    // 📅 ความสัมพันธ์ตารางรอบปฏิทิน
    public function schedules()
    {
        return $this->hasMany(TourSchedule::class);
    }
}