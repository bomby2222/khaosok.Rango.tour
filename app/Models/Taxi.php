<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxi extends Model
{
    use HasFactory;

    // เพิ่ม price_per_person เข้ามาใน fillable เพื่ออนุญาตให้บันทึกลงฐานข้อมูลได้
    protected $fillable = [
        'zone',
        'route_name',
        'from_location',
        'to_location',
        'vehicle_type',
        'price',
        'price_per_person', // 👈 เพิ่มตรงนี้
        'duration',
        'pickup_times',
        'schedule_times',
        'description',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'price_per_person' => 'decimal:2', // 👈 แปลงค่าเป็นทศนิยมเพื่อความแม่นยำ
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];
}