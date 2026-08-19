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

        $query = Booking::with(['user', 'vehicle.brand', 'checkedOutBy', 'checkedInBy'])->latest();

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
     * Menampilkan detail booking
     */
    public function show($id)
    {
        $booking = Booking::with(['user', 'vehicle.brand', 'vehicle.category', 'statusLogs.user', 'checkedOutBy', 'checkedInBy'])
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

        if ($booking->status !== 'approved') {
            return redirect()->back()->with('error', 'Proses Check-Out gagal. Kendaraan hanya bisa diserahterimakan jika booking berstatus Approved.');
        }

        $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($booking, $request) {
            $oldStatus = $booking->status;

            $booking->update([
                'status'         => 'ongoing',
                'checked_out_at' => now(),
                'checked_out_by' => Auth::id(),
            ]);

            if ($booking->vehicle) {
                $booking->vehicle->update([
                    'status' => VehicleStatus::RENTED->value,
                ]);
            }

            BookingStatusLog::create([
                'booking_id'  => $booking->id,
                'user_id'     => Auth::id(),
                'from_status' => $oldStatus,
                'to_status'   => 'ongoing',
                'notes'       => $request->notes ?? 'Kendaraan resmi diserahterimakan kepada customer (Check-Out Berhasil).',
            ]);

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
            ->with('success', 'Serah terima kendaraan (Check-Out) berhasil! Status booking kini "Sedang Disewa" dan status unit "Rented".');
    }

    /**
     * Halaman khusus daftar kendaraan yang SEDANG DISEWA / SIAP DIKEMBALIKAN (Check-In)
     */
    public function returnReady()
    {
        $bookings = Booking::with(['user', 'vehicle.brand', 'checkedOutBy'])
            ->where('status', 'ongoing')
            ->latest()
            ->paginate(10);

        return view('admin.bookings.return-ready', compact('bookings'));
    }

    /**
     * PROSES PENGEMBALIAN KENDARAAN (Check-In)
     */
    public function processReturn(Request $request, $id)
    {
        $booking = Booking::with('vehicle')->findOrFail($id);

        // Validasi Proteksi: Hanya transaksi 'ongoing' dan belum dikembalikan yang bisa diproses
        if ($booking->status !== 'ongoing' || $booking->checked_in_at !== null) {
            return redirect()->back()->with('error', 'Proses pengembalian gagal. Transaksi ini tidak dalam status "Sedang Disewa" atau sudah pernah dikembalikan.');
        }

        $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($booking, $request) {
            $oldStatus = $booking->status;

            // 1. Catat Waktu Pengembalian Aktual & Admin Penerima
            $booking->update([
                'status'        => 'completed',
                'checked_in_at' => now(),
                'checked_in_by' => Auth::id(),
            ]);

            // 2. Kembalikan Status Kendaraan Menjadi AVAILABLE (Siap Disewa Kembali)
            if ($booking->vehicle) {
                $booking->vehicle->update([
                    'status' => VehicleStatus::AVAILABLE->value,
                ]);
            }

            // 3. Mencatat Log Perubahan Status Booking
            BookingStatusLog::create([
                'booking_id'  => $booking->id,
                'user_id'     => Auth::id(),
                'from_status' => $oldStatus,
                'to_status'   => 'completed',
                'notes'       => $request->notes ?? 'Kendaraan telah diterima kembali oleh admin di garasi (Check-In Selesai).',
            ]);

            // 4. Catat Activity Log Sistem
            ActivityLog::create([
                'user_id'     => Auth::id(),
                'action'      => 'CHECKIN_BOOKING',
                'description' => "Admin " . Auth::user()->name . " menerima pengembalian unit {$booking->vehicle->name} ({$booking->vehicle->plate_number}) untuk Invoice {$booking->invoice_number}.",
                'subject_type' => Booking::class,
                'subject_id'   => $booking->id,
                'ip_address'   => $request->ip(),
            ]);
        });

        return redirect()->route('admin.bookings.show', $booking->id)
            ->with('success', 'Pengembalian kendaraan (Check-In) berhasil! Status kendaraan kini kembali "Available" dan siap disewa oleh pelanggan lain.');
    }
}