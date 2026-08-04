<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BookingAvailabilityService;
use Illuminate\Http\Request;

class VehicleAvailabilityController extends Controller
{
    public function check(Request $request, $vehicle_id)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
        ]);

        $available = BookingAvailabilityService::isAvailable(
            $vehicle_id,
            $request->start_date,
            $request->end_date
        );

        return response()->json([
            'available' => $available,
            'message'   => $available ? 'Kendaraan tersedia pada tanggal tersebut.' : 'Maaf, kendaraan sudah dibooking pada rentang tanggal tersebut.',
        ]);
    }
}