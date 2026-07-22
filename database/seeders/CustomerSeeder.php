<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Joko Anwar',
            'email'    => 'jokoanwar@rentride.com',
            'password' => Hash::make('password1'),
            'phone'    => '089876543210',
            'role'     => 'customer',
            'status'   => true,
        ]);
    }
}