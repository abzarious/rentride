<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penalty;
use Illuminate\Http\Request;

class PenaltyController extends Controller
{
    /**
     * Menampilkan daftar seluruh denda keterlambatan
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = Penalty::with(['booking.user', 'booking.vehicle'])->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $penalties = $query->paginate(10)->withQueryString();

        $stats = [
            'total_penalties' => Penalty::count(),
            'total_amount'    => Penalty::sum('amount'),
            'unpaid_amount'   => Penalty::where('status', 'unpaid')->sum('amount'),
            'paid_amount'     => Penalty::where('status', 'paid')->sum('amount'),
        ];

        return view('admin.penalties.index', compact('penalties', 'stats', 'status'));
    }

    /**
     * Menampilkan detail denda keterlambatan
     */
    public function show(Penalty $penalty)
    {
        $penalty->load(['booking.user', 'booking.vehicle.brand', 'booking.checkedInBy']);

        return view('admin.penalties.show', compact('penalty'));
    }

    /**
     * Mengubah status pelunasan denda
     */
    public function updateStatus(Request $request, Penalty $penalty)
    {
        $request->validate([
            'status' => 'required|in:unpaid,paid',
        ]);

        $penalty->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Status pelunasan denda berhasil diperbarui!');
    }
}