<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('taxis', function (Blueprint $table) {
            if (!Schema::hasColumn('taxis', 'from_location')) {
                $table->string('from_location')->nullable()->after('route_name');
            }
            if (!Schema::hasColumn('taxis', 'to_location')) {
                $table->string('to_location')->nullable()->after('from_location');
            }
            if (!Schema::hasColumn('taxis', 'price_per_person')) {
                $table->decimal('price_per_person', 10, 2)->nullable()->after('price');
            }
        });
    }

    public function down(): void
    {
        Schema::table('taxis', function (Blueprint $table) {
            $table->dropColumn(['from_location', 'to_location', 'price_per_person']);
        });
    }
};