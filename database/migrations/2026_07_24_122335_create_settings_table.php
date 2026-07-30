<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            // General Info
            $table->string('company_name')->default('RentRide');
            $table->string('logo')->nullable();
            
            // Contact Info
            $table->string('whatsapp')->default('6281234567890');
            $table->string('phone')->nullable()->default('081234567890');
            $table->string('email')->nullable()->default('info@rentride.id');
            $table->text('address')->nullable();
            
            // Visual / Theme Colors
            $table->string('primary_color')->default('#111827');
            $table->string('secondary_color')->default('#D97706');
            
            // Bank Info
            $table->string('bank_name')->nullable()->default('BCA');
            $table->string('bank_number')->nullable()->default('1234567890');
            $table->string('bank_holder')->nullable()->default('PT RentRide Indonesia');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};