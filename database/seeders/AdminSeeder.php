<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Administrator RentRide',
            'email'    => 'admin@rentride.com',
            'password' => Hash::make('rentridepass'),
            'phone'    => '081234567890',
            'role'     => 'admin',
            'status'   => true,
        ]);
    }
}