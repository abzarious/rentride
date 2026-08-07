<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Vehicle;
use App\Enums\VehicleStatus;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // 1. Tampilkan Daftar Seluruh Booking dengan Filter Status
    public function index()
    {
        $status = request('status', 'all');

        $query = Booking::with(['user', 'vehicle.brand'])->latest();

        if ($status && in_array($status, ['pending', 'approved', 'ongoing', 'completed', 'rejected', 'cancelled'])) {
            $query->where('status', $status);
        }

        $bookings = $query->paginate(15);

        // Hitung Statistik Per Status
        $counts = [
            'all'       => Booking::count(),
            'pending'   => Booking::where('status', 'pending')->count(),
            'approved'  => Booking::where('status', 'approved')->count(),
            'ongoing'   => Booking::where('status', 'ongoing')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'rejected'  => Booking::where('status', 'rejected')->count(),
        ];

        return view('admin.bookings.index', compact('bookings', 'counts', 'status'));
    }

    // 2. Detail Booking Sisi Admin
    public function show($id)
    {
        $booking = Booking::with(['user.profile', 'vehicle.brand', 'vehicle.category'])->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    // 3. Update Status Booking (Hanya Admin)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,ongoing,completed,rejected,cancelled',
        ]);

        $booking = Booking::with('vehicle')->findOrFail($id);

        // Mencegah perubahan jika transaksi sudah selesai/batal
        if (in_array($booking->status, ['completed', 'rejected', 'cancelled'])) {
            return back()->with('error', 'Status transaksi ini sudah final dan tidak dapat diubah lagi.');
        }

        $newStatus = $request->status;
        $booking->status = $newStatus;
        $booking->save();

        // Singkronisasi Status Master Kendaraan Otomatis
        if ($booking->vehicle) {
            if ($newStatus === 'approved') {
                $booking->vehicle->update(['status' => VehicleStatus::BOOKED->value]);
            } elseif ($newStatus === 'ongoing') {
                $booking->vehicle->update(['status' => VehicleStatus::RENTED->value]);
            } elseif (in_array($newStatus, ['completed', 'rejected', 'cancelled'])) {
                $booking->vehicle->update(['status' => VehicleStatus::AVAILABLE->value]);
            }
        }

        return redirect()->route('admin.bookings.show', $booking->id)
            ->with('success', 'Status booking berhasil diperbarui menjadi ' . strtoupper($newStatus));
    }
}