<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingStatusLog;
use App\Enums\VehicleStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PaymentVerificationController extends Controller
{
    // Tampilkan Daftar Pembayaran yang Perlu Diverifikasi Admin
    public function index()
    {
        $status = request('status', 'all');

        $query = Booking::with(['user', 'vehicle.brand'])->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $payments = $query->paginate(10);

        $counts = [
            'all'       => Booking::count(),
            'pending'   => Booking::where('status', 'pending')->count(),
            'approved'  => Booking::where('status', 'approved')->count(),
            'rejected'  => Booking::where('status', 'rejected')->count(),
        ];

        return view('admin.payments.index', compact('payments', 'counts', 'status'));
    }

    // Detail Pembayaran & Bukti Transfer
    public function show($id)
    {
        $booking = Booking::with(['user.profile', 'vehicle.brand', 'vehicle.category', 'statusLogs.user'])
            ->findOrFail($id);

        return view('admin.payments.show', compact('booking'));
    }

    // Eksekusi Verifikasi Pembayaran (Approve, Reject, Pending)
    public function verify(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending',
            'notes'  => 'nullable|string|max:500',
        ]);

        $booking = Booking::with('vehicle')->findOrFail($id);

        $oldStatus = $booking->status;
        $newStatus = $request->status;

        DB::transaction(function () use ($booking, $oldStatus, $newStatus, $request) {
            // 1. Update Status Booking
            $booking->update([
                'status' => $newStatus,
            ]);

            // 2. Sinkronkan Status Kendaraan
            if ($booking->vehicle) {
                if ($newStatus === 'approved') {
                    $booking->vehicle->update(['status' => VehicleStatus::BOOKED->value]);
                } elseif ($newStatus === 'pending') {
                    $booking->vehicle->update(['status' => VehicleStatus::AVAILABLE->value]);
                } elseif ($newStatus === 'rejected') {
                    $booking->vehicle->update(['status' => VehicleStatus::AVAILABLE->value]);
                }
            }

            // 3. Catat ke Tabel booking_status_logs (Persetujuan / Penolakan Admin)
            BookingStatusLog::create([
                'booking_id'  => $booking->id,
                'user_id'     => Auth::id(),
                'from_status' => $oldStatus,
                'to_status'   => $newStatus,
                'notes'       => $request->notes ?? ('Verifikasi admin: ' . ucfirst($newStatus)),
            ]);
        });

        $message = match ($newStatus) {
            'approved' => 'Pembayaran berhasil DISETUJUI. Status booking kini Approved.',
            'rejected' => 'Pembayaran DITOLAK. Kendaraan dikembalikan ke status Tersedia.',
            'pending'  => 'Status pembayaran dikembalikan ke PENDING.',
        };

        return redirect()->route('admin.payments.show', $booking->id)
            ->with('success', $message);
    }
}