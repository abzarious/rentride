<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingStatusLog;
use App\Models\ActivityLog;
use App\Enums\VehicleStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'status'        => 'required|in:approved,rejected,pending',
            'payment_proof' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096', // Maksimal 4MB
            'notes'         => 'nullable|string|max:500',
        ]);

        $booking = Booking::findOrFail($id);
        $oldStatus = $booking->status;

        // 1. Upload / Ganti Gambar Bukti Transfer
        if ($request->hasFile('payment_proof')) {
            // Hapus gambar lama di storage jika ada
            if ($booking->payment_proof && Storage::disk('public')->exists($booking->payment_proof)) {
                Storage::disk('public')->delete($booking->payment_proof);
            }

            // Simpan gambar baru ke folder storage/app/public/payments
            $path = $request->file('payment_proof')->store('payments', 'public');
            $booking->payment_proof = $path;
        }

        // 2. Update Status dan Catatan Booking
        $booking->status = $request->status;
        if ($request->filled('notes')) {
            $booking->notes = $request->notes;
        }
        $booking->save();

        // 3. Update Status Unit Kendaraan jika Approved -> Booked
        if ($request->status === 'approved') {
            $booking->vehicle->update(['status' => 'booked']);
        } elseif (in_array($request->status, ['rejected', 'pending']) && $oldStatus === 'approved') {
            $booking->vehicle->update(['status' => 'available']);
        }

        // 4. Catat Riwayat Log Status Booking
        BookingStatusLog::create([
            'booking_id'  => $booking->id,
            'user_id'     => Auth::id(),
            'from_status' => $oldStatus,
            'to_status'   => $request->status,
            'notes'       => $request->notes ?? ('Verifikasi status diubah menjadi ' . strtoupper($request->status)),
        ]);

        // 5. Catat Activity Log Sistem
        ActivityLog::create([
            'user_id'      => Auth::id(),
            'action'       => 'VERIFY_PAYMENT',
            'description'  => "Memverifikasi pembayaran invoice {$booking->invoice_number} menjadi {$request->status}.",
            'subject_type' => Booking::class,
            'subject_id'   => $booking->id,
            'ip_address'   => $request->ip(),
        ]);

        return redirect()->back()->with('success', 'Verifikasi pembayaran dan bukti transfer berhasil diperbarui!');
    }
}