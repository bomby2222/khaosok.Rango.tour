<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Anonymous Traveler');
            $table->boolean('is_anonymous')->default(false);
            $table->unsignedTinyInteger('rating')->default(5); // 1 ถึง 5 ดาว
            $table->text('comment');
            $table->string('image')->nullable(); // อัปโหลดรูปภาพบรรยากาศ/รีวิว
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};