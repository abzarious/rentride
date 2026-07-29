<?php

namespace Database\Factories;

use App\Enums\VehicleStatus;
use App\Models\Brand;
use App\Models\VehicleCategory;
use App\Models\VehicleType;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    public function definition(): array
    {
        $brands = Brand::pluck('id')->toArray();
        $categories = VehicleCategory::pluck('id')->toArray();
        $types = VehicleType::pluck('id')->toArray();

        return [
            'brand_id'        => fake()->randomElement($brands),
            'category_id'     => fake()->randomElement($categories),
            'vehicle_type_id' => fake()->randomElement($types),
            'name'            => fake()->randomElement(['Toyota Innova Zenix', 'Honda HR-V', 'Yamaha NMAX Turbo', 'Honda PCX 160', 'Mitsubishi Pajero Sport', 'Toyota Fortuner']),
            'plate_number'    => strtoupper(fake()->bothify('N #### ??')),
            'year'            => fake()->numberBetween(2020, 2026),
            'color'           => fake()->randomElement(['Hitam Metalik', 'Putih Mutiara', 'Abu-Abu', 'Merah']),
            'price_per_day'   => fake()->randomElement([150000, 250000, 350000, 500000, 800000, 1200000]),
            'transmission'    => fake()->randomElement(['Automatic', 'Manual']),
            'fuel_type'       => fake()->randomElement(['Bensin', 'Diesel']),
            'thumbnail'       => null,
            'description'     => 'Kendaraan terawat, AC dingin, siap pakai untuk perjalanan luar kota.',
            'status'          => VehicleStatus::AVAILABLE,
        ];
    }
}