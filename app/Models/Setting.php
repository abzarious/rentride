<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'logo',
        'whatsapp',
        'phone',
        'email',
        'address',
        'primary_color',
        'secondary_color',
        'bank_name',
        'bank_number',
        'bank_holder',
    ];

    /**
     * Helper Static untuk mengambil baris setting tunggal (Single Record Pattern)
     */
    public static function getSetting()
    {
        return self::first() ?? self::create([
            'company_name' => 'RentRide',
            'whatsapp'     => '6281234567890',
            'email'        => 'info@rentride.id',
            'address'      => 'Jl. Soekarno Hatta No. 45, Malang, Jawa Timur',
            'bank_name'    => 'BCA',
            'bank_number'  => '1234567890',
            'bank_holder'  => 'PT RentRide Indonesia'
        ]);
    }
}