<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('taxis', function (Blueprint $table) {
            $table->id();
            $table->string('zone'); // phuket, khaosok, phangnga, krabi
            $table->string('route_name'); // เช่น "Phuket Airport -> Cheow Lan Lake Pier"
            $table->string('vehicle_type')->default('VIP Minivan'); // Sedan, SUV, VIP Minivan
            $table->decimal('price', 10, 2); // ราคา
            $table->string('duration')->nullable(); // เช่น "2.5 - 3 Hours"
            $table->string('pickup_times')->nullable(); // เช่น "08:00, 11:30, 15:00 หรือ On-Demand 24/7"
            $table->text('description')->nullable(); // คำอธิบาย/รวมน้ำมัน/คนขับ
            $table->boolean('status')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('taxis');
    }
};