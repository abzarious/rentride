<?php

namespace Database\Seeders;

use App\Models\VehicleType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VehicleTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'SUV', 'description' => 'Sport Utility Vehicle - Tangguh di segala medan.'],
            ['name' => 'MPV', 'description' => 'Multi Purpose Vehicle - Nyaman untuk keluarga.'],
            ['name' => 'Sedan', 'description' => 'Mobil Sedan mewah dan elegan.'],
            ['name' => 'Sport', 'description' => 'Kendaraan performa tinggi.'],
            ['name' => 'Scooter', 'description' => 'Motor matic santai dan lincah.'],
            ['name' => 'Matic', 'description' => 'Motor transmisi otomatis perkotaan.'],
            ['name' => 'Bebek', 'description' => 'Motor bebek irit bahan bakar.'],
            ['name' => 'Trail', 'description' => 'Motor offroad dan petualangan.'],
        ];

        foreach ($types as $type) {
            VehicleType::firstOrCreate(
                ['name' => $type['name']],
                [
                    'slug' => Str::slug($type['name']),
                    'description' => $type['description'],
                ]
            );
        }
    }
}