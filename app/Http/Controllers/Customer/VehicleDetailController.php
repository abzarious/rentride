<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Setting;
use Illuminate\Http\Request;

class VehicleDetailController extends Controller
{
    public function show($id)
    {
        $vehicle = Vehicle::with(['brand', 'category', 'type', 'images'])
            ->where('status', '!=', 'inactive')
            ->findOrFail($id);

        $setting = Setting::first();

        // Kendaraan serupa sebagai rekomendasi
        $relatedVehicles = Vehicle::with(['brand', 'category'])
            ->where('category_id', $vehicle->category_id)
            ->where('id', '!=', $vehicle->id)
            ->where('status', 'available')
            ->take(3)
            ->get();

        return view('customer.vehicles.show', compact('vehicle', 'setting', 'relatedVehicles'));
    }
}