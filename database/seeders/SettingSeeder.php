<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::firstOrCreate(
            ['id' => 1],
            [
                'company_name'    => 'RentRide',
                'phone'           => '081234567890',
                'whatsapp'        => '6281234567890',
                'email'           => 'info@rentride.com',
                'address'         => 'Jl. Soekarno Hatta No. 45, Kota Malang, Jawa Timur',
                'primary_color'   => '#111827',
                'secondary_color' => '#D97706',
                'bank_name'       => 'BCA',
                'bank_number'     => '1234567890',
                'bank_holder'     => 'PT RentRide Indonesia',
            ]
        );
    }
}