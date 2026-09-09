<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 1. ให้ Laravel รองรับ Reverse Proxy จาก Cloudflare Tunnel
        $middleware->trustProxies(at: '*');

        // 2. 🔑 ข้ามการตรวจ CSRF Token สำหรับหน้าล็อกอิน (แก้ Error 419 บน Cloudflare ทันที)
        $middleware->validateCsrfTokens(except: [
            'rango-admin/login',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();