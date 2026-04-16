<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trip_itineraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('trip_name');
            $table->date('trip_date')->nullable();
            $table->timestamps();
        });

        Schema::create('trip_attractions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained('trip_itineraries')->onDelete('cascade');
            $table->foreignId('attraction_id')->constrained('attractions', 'attraction_id')->onDelete('cascade');
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trip_attractions');
        Schema::dropIfExists('trip_itineraries');
    }
};