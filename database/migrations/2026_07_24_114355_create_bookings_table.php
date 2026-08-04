<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            
            // Format unik: INV202608040001
            $table->string('invoice_number')->unique();
            
            // Relasi User & Kendaraan
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('vehicle_id')
                ->constrained('vehicles')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Tanggal & Waktu Waktu Rental
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->unsignedInteger('duration_days'); // Total Hari/Durasi

            // Biaya & Rincian
            $table->unsignedInteger('price_per_day');
            $table->unsignedInteger('subtotal');
            $table->unsignedInteger('discount')->default(0);
            $table->unsignedInteger('total_price');

            // Status Booking: pending, approved, rejected, ongoing, completed, cancelled
            $table->string('status')->default('pending');
            
            $table->text('notes')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};