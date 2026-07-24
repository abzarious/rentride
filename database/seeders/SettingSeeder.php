<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::create([
            'company_name'    => 'RentalHub Premium Service',
            'primary_color'   => '#111827',
            'secondary_color' => '#D97706',
            'whatsapp'        => '6281234567890',
            'address'         => 'Jl. Soekarno Hatta No. 45, Kota Malang, Jawa Timur',
            'bank_rekening'   => "BCA: 1234567890 a.n. RentalHub\nMandiri: 0987654321 a.n. RentalHub"
        ]);
    }
}