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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->default('RentalHub');
            $table->string('logo')->nullable();
            $table->string('primary_color')->default('#111827');
            $table->string('secondary_color')->default('#D97706');
            $table->string('whatsapp')->default('6281234567890');
            $table->text('address')->nullable();
            $table->text('bank_rekening')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
