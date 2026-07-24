<?php

namespace Database\Seeders;

use App\Models\VehicleType;
use Illuminate\Database\Seeder;

class VehicleTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = ['SUV', 'MPV', 'Sport', 'Scooter', 'Matic', 'Sedan'];
        foreach ($types as $type) {
            VehicleType::create(['name' => $type]);
        }
    }
}