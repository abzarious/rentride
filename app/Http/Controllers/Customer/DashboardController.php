<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Hitung Statistik Real dari Database
        $stats = [
            'pending'   => Booking::where('user_id', $userId)->where('status', 'pending')->count(),
            'active'    => Booking::where('user_id', $userId)->whereIn('status', ['approved', 'ongoing'])->count(),
            'completed' => Booking::where('user_id', $userId)->where('status', 'completed')->count(),
            'cancelled' => Booking::where('user_id', $userId)->whereIn('status', ['rejected', 'cancelled'])->count(),
        ];

        // Ambil Booking Aktif Saat Ini
        $activeBooking = Booking::with(['vehicle.brand', 'vehicle.category'])
            ->where('user_id', $userId)
            ->whereIn('status', ['approved', 'ongoing'])
            ->latest()
            ->first();

        // Ambil 5 Booking Terbaru
        $recentBookings = Booking::with(['vehicle.brand'])
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('customer.dashboard', compact('stats', 'activeBooking', 'recentBookings'));
    }
}