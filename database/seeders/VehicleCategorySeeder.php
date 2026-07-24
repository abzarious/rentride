<?php

namespace Database\Seeders;

use App\Models\VehicleCategory;
use Illuminate\Database\Seeder;

class VehicleCategorySeeder extends Seeder
{
    public function run(): void
    {
        VehicleCategory::create(['name' => 'Mobil']);
        VehicleCategory::create(['name' => 'Motor']);
    }
}
