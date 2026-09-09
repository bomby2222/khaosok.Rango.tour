<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resorts', function (Blueprint $table) {
            $table->id();
            $table->string('name');             // เช่น LAGUNA, Panvaree, Saichol
            $table->string('prefix')->nullable(); // เช่น THE, หรือเว้นว่างได้
            $table->string('subtitle')->nullable(); // เช่น CHIEWLAN, Resort, The Greenery, Floating Resort
            $table->string('image');            // รูปภาพแพ/รีสอร์ท
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resorts');
    }
};