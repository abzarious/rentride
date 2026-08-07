<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete(); // Admin / User pelaksana
                
            $table->string('action'); // Contoh: APPROVE_BOOKING, REJECT_BOOKING, CHANGE_VEHICLE_STATUS
            $table->text('description');
            $table->nullableMorphs('subject'); // subject_type & subject_id (Relasi ke Booking/Vehicle)
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};