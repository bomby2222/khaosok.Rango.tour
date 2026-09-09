<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 🔒 บังคับใช้ HTTPS บน Production หรือเมื่อต่อผ่าน Reverse Proxy (Render / Cloudflare)
        if (
            app()->environment('production') ||
            (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ||
            (isset($_SERVER['HTTP_HOST']) && str_contains($_SERVER['HTTP_HOST'], 'trycloudflare.com')) ||
            request()->header('x-forwarded-proto') === 'https'
        ) {
            URL::forceScheme('https');
        }

        // 🛡️ แชร์ค่า settings ไปยังทุกหน้า พร้อมป้องกัน Error หาก Database ยังเชื่อมต่อไม่ได้
        try {
            if (Schema::hasTable('settings')) {
                $settings = Setting::pluck('value', 'key')->toArray();
                View::share('settings', $settings);
            } else {
                View::share('settings', []);
            }
        } catch (\Throwable $e) {
            // หากต่อ Database ไม่ติด จะส่ง array ว่างไปแทน ทำให้เว็บไม่แครชเป็น Error 500
            View::share('settings', []);
        }
    }
}