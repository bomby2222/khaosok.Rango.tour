<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('route_maps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->nullable()->constrained('tours')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('route_color')->default('#10b981'); // สีเส้นทาง
            $table->decimal('center_lat', 10, 7)->default(8.9772); // ละติจูดเริ่มต้น (เขื่อนเชี่ยวหลาน)
            $table->decimal('center_lng', 10, 7)->default(98.8202); // ลองจิจูดเริ่มต้น
            $table->integer('zoom_level')->default(11);
            $table->json('waypoints')->nullable(); // จุดเชื่อมโยง [{name, lat, lng, type, description}]
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('route_maps');
    }
};