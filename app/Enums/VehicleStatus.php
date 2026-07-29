<?php

namespace App\Enums;

enum VehicleStatus: string
{
    case AVAILABLE   = 'available';
    case BOOKED      = 'booked';
    case RENTED      = 'rented';
    case MAINTENANCE = 'maintenance';
    case INACTIVE    = 'inactive';

    public function label(): string
    {
        return match($this) {
            self::AVAILABLE   => 'Tersedia',
            self::BOOKED      => 'Dibooking',
            self::RENTED      => 'Sedang Dirental',
            self::MAINTENANCE => 'Dalam Perbaikan',
            self::INACTIVE    => 'Nonaktif',
        };
    }
}