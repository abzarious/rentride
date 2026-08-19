<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penalties', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel bookings
            $table->foreignId('booking_id')
                ->constrained('bookings')
                ->cascadeOnDelete();

            $table->unsignedInteger('late_minutes')->default(0);
            $table->unsignedInteger('late_hours')->default(0);
            $table->decimal('amount', 15, 2)->default(0);
            
            // Status denda: 'unpaid' (belum dibayar) atau 'paid' (lunas)
            $table->string('status')->default('unpaid');
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penalties');
    }
};