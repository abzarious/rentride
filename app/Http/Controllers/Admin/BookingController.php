<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingStatusLog;
use App\Models\ActivityLog;
use App\Enums\VehicleStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Menampilkan seluruh daftar booking dengan filter status
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = Booking::with(['user', 'vehicle.brand', 'checkedOutBy'])->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $bookings = $query->paginate(10)->withQueryString();

        $counts = [
            'all'       => Booking::count(),
            'pending'   => Booking::where('status', 'pending')->count(),
            'approved'  => Booking::where('status', 'approved')->count(),
            'ongoing'   => Booking::where('status', 'ongoing')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];

        return view('admin.bookings.index', compact('bookings', 'counts', 'status'));
    }

    /**
     * Menampilkan detail booking untuk serah terima / Check-Out
     */
    public function show($id)
    {
        $booking = Booking::with(['user', 'vehicle.brand', 'vehicle.category', 'statusLogs.user', 'checkedOutBy'])
            ->findOrFail($id);

        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Halaman khusus daftar booking yang SIAP DI-CHECK-OUT (Status Approved)
     */
    public function checkoutReady()
    {
        $bookings = Booking::with(['user', 'vehicle.brand'])
            ->where('status', 'approved')
            ->latest()
            ->paginate(10);

        return view('admin.bookings.checkout-ready', compact('bookings'));
    }

    /**
     * PROSES CHECK-OUT (Serah Terima Kendaraan)
     */
    public function processCheckout(Request $request, $id)
    {
        $booking = Booking::with('vehicle')->findOrFail($id);

        // Protection: Hanya booking status 'approved' yang bisa di Check-Out
        if ($booking->status !== 'approved') {
            return redirect()->back()->with('error', 'Proses Check-Out gagal. Kendaraan hanya bisa diserahterimakan jika booking dalam status Approved.');
        }

        $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($booking, $request) {
            $oldStatus = $booking->status;

            // 1. Update Status Booking -> Sedang Disewa (ongoing) & Catat Waktu/Admin
            $booking->update([
                'status'         => 'ongoing',
                'checked_out_at' => now(),
                'checked_out_by' => Auth::id(),
            ]);

            // 2. Update Status Kendaraan -> Rented
            if ($booking->vehicle) {
                $booking->vehicle->update([
                    'status' => VehicleStatus::RENTED->value,
                ]);
            }

            // 3. Catat Riwayat Log Status Booking
            BookingStatusLog::create([
                'booking_id'  => $booking->id,
                'user_id'     => Auth::id(),
                'from_status' => $oldStatus,
                'to_status'   => 'ongoing',
                'notes'       => $request->notes ?? 'Kendaraan resmi diserahterimakan kepada customer (Check-Out Berhasil).',
            ]);

            // 4. Catat Activity Log Sistem
            ActivityLog::create([
                'user_id'     => Auth::id(),
                'action'      => 'CHECKOUT_BOOKING',
                'description' => "Admin " . Auth::user()->name . " melakukan Check-Out unit {$booking->vehicle->name} ({$booking->vehicle->plate_number}) untuk Invoice {$booking->invoice_number}.",
                'subject_type' => Booking::class,
                'subject_id'   => $booking->id,
                'ip_address'   => $request->ip(),
            ]);
        });

        return redirect()->route('admin.bookings.show', $booking->id)
            ->with('success', 'Serah terima kendaraan (Check-Out) berhasil! Status booking kini "Sedang Disewa" dan status unit kendaraan "Rented".');
    }
}