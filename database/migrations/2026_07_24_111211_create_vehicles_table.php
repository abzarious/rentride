<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            // Relasi ke Master Data
            $table->foreignId('brand_id')
                ->constrained('brands')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('category_id')
                ->constrained('vehicle_categories')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('vehicle_type_id')
                ->constrained('vehicle_types')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Detail Kendaraan
            $table->string('name');
            $table->string('plate_number')->unique();
            $table->year('year');
            $table->string('color');
            $table->unsignedInteger('price_per_day'); // Tipe data integer untuk Rupiah
            $table->string('transmission'); // Automatic / Manual
            $table->string('fuel_type');    // Bensin / Diesel / Listrik
            $table->string('thumbnail')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('available'); // Status dari Enum

            $table->timestamps();
            $table->softDeletes(); // Keamanan soft delete
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};