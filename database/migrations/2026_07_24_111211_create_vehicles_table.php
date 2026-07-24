<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vehicle_category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vehicle_type_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('plate_number')->unique();
            $table->year('year');
            $table->string('color');
            $table->string('transmission'); // Automatic / Manual
            $table->string('fuel'); // Bensin, Diesel, Listrik
            $table->decimal('price_per_day', 12, 2);
            $table->enum('status', ['available', 'booked', 'rented', 'maintenance', 'inactive'])->default('available');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
