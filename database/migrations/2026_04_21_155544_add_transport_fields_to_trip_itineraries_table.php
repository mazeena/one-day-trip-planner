<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trip_itineraries', function (Blueprint $table) {
            $table->string('transport_mode')->default('car')->after('trip_date');
            $table->string('starting_location')->nullable()->after('transport_mode');
            $table->decimal('start_lat', 10, 7)->nullable()->after('starting_location');
            $table->decimal('start_lng', 10, 7)->nullable()->after('start_lat');
        });
    }

    public function down(): void
    {
        Schema::table('trip_itineraries', function (Blueprint $table) {
            $table->dropColumn(['transport_mode', 'starting_location', 'start_lat', 'start_lng']);
        });
    }
};
