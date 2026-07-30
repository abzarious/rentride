<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Query Total Kendaraan & Kategori
        $total_kendaraan = Vehicle::count();
        $total_mobil     = Vehicle::whereHas('category', function ($q) {
            $q->where('name', 'Mobil');
        })->count();
        $total_motor     = Vehicle::whereHas('category', function ($q) {
            $q->where('name', 'Motor');
        })->count();

        // 2. Query Status Kendaraan
        $total_available   = Vehicle::where('status', 'available')->count();
        $total_booked      = Vehicle::where('status', 'booked')->count();
        $total_rented      = Vehicle::where('status', 'rented')->count();
        $total_maintenance = Vehicle::where('status', 'maintenance')->count();
        $total_inactive    = Vehicle::where('status', 'inactive')->count();

        // 3. Query Statistik Tambahan (Customer & Booking)
        $total_customer   = User::where('role', 'customer')->count();
        $booking_hari_ini = Booking::whereDate('created_at', today())->count();
        $total_pendapatan = Booking::where('status', 'completed')->sum('total');

        // 4. Query Data Terbaru (Widget Programmer D)
        $latest_vehicles = Vehicle::with(['brand', 'category', 'vehicleType'])
            ->latest()
            ->take(5)
            ->get();

        $available_vehicles = Vehicle::with(['brand', 'category', 'vehicleType'])
            ->where('status', 'available')
            ->latest()
            ->take(5)
            ->get();

        $maintenance_vehicles = Vehicle::with(['brand', 'category', 'vehicleType'])
            ->where('status', 'maintenance')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'total_kendaraan',
            'total_mobil',
            'total_motor',
            'total_available',
            'total_booked',
            'total_rented',
            'total_maintenance',
            'total_inactive',
            'total_customer',
            'booking_hari_ini',
            'total_pendapatan',
            'latest_vehicles',
            'available_vehicles',
            'maintenance_vehicles'
        ));
    }
}