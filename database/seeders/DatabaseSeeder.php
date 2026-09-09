<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // สร้างบัญชี Admin สำหรับเข้าหลังบ้าน
        User::create([
            'name' => 'Rango Admin',
            'email' => 'admin@rangotour.com',
            'password' => Hash::make('password123'),
        ]);

        // กำหนดการตั้งค่าเริ่มต้น
        $settings = [
            'site_name' => 'Rango ทัวร์',
            'phone' => '0812345678',
            'line_id' => '@rangotour',
            'line_url' => 'https://line.me/ti/p/~@rangotour',
            'whatsapp_number' => '66812345678',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}