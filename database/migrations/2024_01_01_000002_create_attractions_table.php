<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attractions', function (Blueprint $table) {
            $table->id('attraction_id');
            $table->foreignId('category_id')->constrained('categories', 'category_id')->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->decimal('distance', 5, 2)->comment('Distance in km from Malwana');
            $table->string('image')->nullable();
            $table->string('location')->comment('Google Maps embed URL or coordinates');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attractions');
    }
};
