<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = ['Honda', 'Toyota', 'Yamaha', 'Suzuki', 'Daihatsu', 'Mitsubishi'];
        foreach ($brands as $brand) {
            Brand::create(['name' => $brand]);
        }
    }
}