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

class PaymentVerificationController extends Controller
{
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

    public function show($id)
    {
        $booking = Booking::with(['user', 'vehicle.brand', 'vehicle.category', 'statusLogs.user'])
            ->findOrFail($id);

        return view('admin.payments.show', compact('booking'));
    }

    public function verify(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending',
            'notes'  => 'nullable|string|max:500',
        ]);

        $booking = Booking::with('vehicle')->findOrFail($id);

        // Validasi Mencegah Re-approval
        if ($booking->status === 'approved' && $request->status === 'approved') {
            return redirect()->back()->with('error', 'Booking ini sudah disetujui sebelumnya dan tidak bisa di-approve ulang.');
        }

        $oldStatus = $booking->status;
        $newStatus = $request->status;

        DB::transaction(function () use ($booking, $oldStatus, $newStatus, $request) {
            // 1. Update Status Booking
            $booking->update([
                'status' => $newStatus,
            ]);

            // 2. Programmer B: Perubahan Status Kendaraan Otomatis
            if ($booking->vehicle) {
                if ($newStatus === 'approved') {
                    // Kendaraan berubah dari Available ke Booked
                    $booking->vehicle->update(['status' => VehicleStatus::BOOKED->value]);
                } elseif (in_array($newStatus, ['rejected', 'pending', 'cancelled'])) {
                    // Kendaraan kembali Available
                    $booking->vehicle->update(['status' => VehicleStatus::AVAILABLE->value]);
                }
            }

            // 3. Catat ke Log Status Booking
            BookingStatusLog::create([
                'booking_id'  => $booking->id,
                'user_id'     => Auth::id(),
                'from_status' => $oldStatus,
                'to_status'   => $newStatus,
                'notes'       => $request->notes ?? ('Verifikasi admin: ' . ucfirst($newStatus)),
            ]);

            // 4. Programmer D: Catat Aktivitas ke ActivityLog
            ActivityLog::log(
                action: strtoupper($newStatus) . '_BOOKING',
                description: "Admin " . Auth::user()->name . " mengubah status booking invoice {$booking->invoice_number} dari " . strtoupper($oldStatus) . " menjadi " . strtoupper($newStatus) . ".",
                subject: $booking
            );
        });

        $message = match ($newStatus) {
            'approved' => 'Persetujuan (Approval) berhasil. Status booking menjadi Approved dan kendaraan otomatis terisi status BOOKED.',
            'rejected' => 'Pembayaran/Booking DITOLAK. Kendaraan otomatis dikembalikan ke status Tersedia (Available).',
            'pending'  => 'Status booking dikembalikan ke PENDING.',
        };

        return redirect()->route('admin.payments.show', $booking->id)
            ->with('success', $message);
    }
}