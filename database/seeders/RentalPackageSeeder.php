<?php

namespace Database\Seeders;

use App\Models\RentalPackage;
use Illuminate\Database\Seeder;

class RentalPackageSeeder extends Seeder
{
    public function run(): void
    {
        RentalPackage::create(['name' => '3 Jam', 'duration_hours' => 3]);
        RentalPackage::create(['name' => '12 Jam', 'duration_hours' => 12]);
        RentalPackage::create(['name' => '1 Hari (24 Jam)', 'duration_hours' => 24]);
        RentalPackage::create(['name' => '3 Hari', 'duration_hours' => 72]);
        RentalPackage::create(['name' => '7 Hari (Seminggu)', 'duration_hours' => 168]);
    }
}