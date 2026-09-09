<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ตารางแบนเนอร์หน้าแรก
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('image');
            $table->string('button_text')->default('ดูทัวร์ทั้งหมด');
            $table->string('button_link')->default('/tours');
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        // ตารางข้อมูลทัวร์
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('cover_image');
            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->integer('duration_days')->default(1);
            $table->integer('duration_nights')->default(0);
            $table->string('location');
            $table->string('meeting_point')->nullable();
            $table->text('description')->nullable();
            $table->longText('itinerary')->nullable();
            $table->text('included')->nullable();
            $table->text('excluded')->nullable();
            $table->text('terms')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        // ตารางรูปภาพ Gallery ของทัวร์
        Schema::create('tour_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->onDelete('cascade');
            $table->string('image');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // ตารางรอบการเดินทางและที่นั่งคงเหลือ
        Schema::create('tour_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->onDelete('cascade');
            $table->date('travel_date');
            $table->integer('total_seats')->default(20);
            $table->integer('available_seats')->default(20);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        // ตารางการตั้งค่าทั่วไป (LINE, WhatsApp, ข้อมูลติดต่อ)
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('tour_schedules');
        Schema::dropIfExists('tour_images');
        Schema::dropIfExists('tours');
        Schema::dropIfExists('banners');
    }
};