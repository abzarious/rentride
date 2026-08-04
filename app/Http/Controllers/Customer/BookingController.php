<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // 1. Menu Booking Saya (Sewa Aktif & Menunggu Konfirmasi)
    public function index()
    {
        $bookings = Booking::with(['vehicle.brand', 'payment'])
            ->where('user_id', auth()->id())
            ->whereIn('status', [Booking::STATUS_PENDING, Booking::STATUS_APPROVED, Booking::STATUS_ONGOING])
            ->latest()
            ->paginate(10);

        return view('customer.bookings.index', compact('bookings'));
    }

    // 2. Menu Riwayat Rental (Selesai & Dibatalkan)
    public function history()
    {
        $bookings = Booking::with(['vehicle.brand', 'payment'])
            ->where('user_id', auth()->id())
            ->whereIn('status', [Booking::STATUS_COMPLETED, Booking::STATUS_REJECTED, Booking::STATUS_CANCELLED])
            ->latest()
            ->paginate(10);

        return view('customer.bookings.history', compact('bookings'));
    }
}