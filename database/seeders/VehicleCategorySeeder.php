<?php

namespace Database\Seeders;

use App\Models\VehicleCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VehicleCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Mobil', 'Motor', 'Sepeda Listrik'];

        foreach ($categories as $category) {
            VehicleCategory::firstOrCreate(
                ['name' => $category],
                [
                    'slug'   => Str::slug($category),
                    'status' => true,
                ]
            );
        }
    }
}