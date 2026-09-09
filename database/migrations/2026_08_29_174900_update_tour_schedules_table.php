<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('tour_schedules')) {
            Schema::create('tour_schedules', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tour_id')->constrained()->onDelete('cascade');
                $table->date('travel_date');
                $table->integer('available_seats')->default(20);
                $table->boolean('is_available')->default(true); // true = ว่าง (เขียว), false = เต็ม/ปิดรับ (แดง)
                $table->timestamps();
            });
        } else {
            Schema::table('tour_schedules', function (Blueprint $table) {
                if (!Schema::hasColumn('tour_schedules', 'is_available')) {
                    $table->boolean('is_available')->default(true)->after('available_seats');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_schedules');
    }
};