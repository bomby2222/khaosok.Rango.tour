<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TourController as AdminTourController;
use App\Http\Controllers\Admin\TourCalendarController;
use App\Http\Controllers\Admin\ResortController as AdminResortController;
use App\Http\Controllers\Admin\BannerController as AdminBannerController;
use App\Http\Controllers\Admin\DestinationController as AdminDestinationController;
use App\Http\Controllers\Admin\RouteMapController as AdminRouteMapController;
use App\Http\Controllers\Admin\TaxiController as AdminTaxiController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\ChatController as AdminChatController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;

// ------------------- Public Pages (หน้าบ้าน) -------------------
Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('/about', [FrontController::class, 'about'])->name('about');

// 🗺️ Interactive Route Map (แผนที่ลากเส้นพิกัดเชื่อมต่อการเดินทาง)
Route::get('/route-map', [FrontController::class, 'routeMap'])->name('route.map');

// 🚕 Taxi & Private Transfers (รถรับส่ง 4 โซน: ภูเก็ต เขาสก พังงา กระบี่)
Route::get('/taxi-transfers', [FrontController::class, 'taxiTransfers'])->name('taxi.transfers');

Route::get('/destinations', [FrontController::class, 'destinations'])->name('destinations');
Route::get('/tours', [FrontController::class, 'tours'])->name('tours.index');
Route::get('/tours/{slug}', [FrontController::class, 'show'])->name('tours.show');
Route::get('/contact', [FrontController::class, 'contact'])->name('contact');

// Reviews หน้าบ้าน
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// Live Chat Front End (ถามชื่อก่อนแชท + บอทตอบกลับ + เปลี่ยนชื่อ)
Route::get('/chat/messages', [ChatController::class, 'fetchMessages'])->name('chat.fetch');
Route::post('/chat/init', [ChatController::class, 'initChat'])->name('chat.init');
Route::post('/chat/rename', [ChatController::class, 'updateName'])->name('chat.rename');
Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');

// ------------------- Admin Auth Routes -------------------
Route::get('/rango-admin/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('/rango-admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/rango-admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// ------------------- Protected Admin Panel (ต้อง Login ก่อน) -------------------
Route::prefix('rango-admin')->name('admin.')->middleware('auth')->group(function () {
    // 📊 Dashboard & System Flush Cache
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('flush-cache', [DashboardController::class, 'flushCache'])->name('flushCache');

    Route::resource('banners', AdminBannerController::class);
    Route::resource('tours', AdminTourController::class);
    
    // 📅 ระบบจัดการปฏิทินวันว่าง/วันเต็ม (เขียว 🟢 / แดง 🔴)
    Route::get('tours/{tour}/calendar', [TourCalendarController::class, 'index'])->name('tours.calendar');
    Route::post('tours/{tour}/calendar/toggle', [TourCalendarController::class, 'toggleDate'])->name('tours.calendar.toggle');
    Route::post('tours/{tour}/calendar/seats', [TourCalendarController::class, 'updateSeats'])->name('tours.calendar.seats');

    // 🛶 Welcome to Khao Sok (แพที่พัก 10 ภาพ)
    Route::resource('resorts', AdminResortController::class);

    // 🏝️ Best Tours Hub (Landmarks)
    Route::resource('destinations', AdminDestinationController::class);

    // 🗺️ Interactive Route Maps Builder (ระบบสร้างแผนที่ GPS และจุด Waypoint)
    Route::resource('route-maps', AdminRouteMapController::class);

    // 🚕 Taxi & Transfers Fleet (จัดการเที่ยวรถ 4 โซนและเที่ยวรถย่อย)
    Route::resource('taxis', AdminTaxiController::class);

    Route::resource('reviews', AdminReviewController::class)->only(['index', 'destroy']);
    
    // 💬 Live Chat Terminal (Admin ตอบแชทสด + เปลี่ยนชื่อลูกค้า + ลบแชท)
    Route::get('chats', [AdminChatController::class, 'index'])->name('chats.index');
    Route::get('chats/{id}/conversation', [AdminChatController::class, 'getConversation'])->name('chats.conversation');
    Route::post('chats/{id}/reply', [AdminChatController::class, 'reply'])->name('chats.reply');
    Route::post('chats/{id}/rename', [AdminChatController::class, 'rename'])->name('chats.rename');
    Route::delete('chats/{id}', [AdminChatController::class, 'destroy'])->name('chats.destroy');
    
    // ป้องกัน Error 405 Method Not Allowed เมื่อมีการเปิด GET /rango-admin/chats/{id}
    Route::get('chats/{id}', function () {
        return redirect()->route('admin.chats.index');
    });

    // ⚙️ Settings (WhatsApp, Email, Instagram, Facebook, About Us, Video Popup)
    Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [AdminSettingController::class, 'update'])->name('settings.update');
});