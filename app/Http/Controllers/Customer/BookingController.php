<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Setting;
use App\Services\InvoiceService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingController extends Controller
{
    // 1. Menampilkan Daftar Booking Aktif Customer
    public function index()
    {
        $bookings = Booking::with(['vehicle.brand', 'payment'])
            ->where('user_id', Auth::id())
            ->whereIn('status', [Booking::STATUS_PENDING, Booking::STATUS_APPROVED, Booking::STATUS_ONGOING])
            ->latest()
            ->paginate(10);

        return view('customer.bookings.index', compact('bookings'));
    }

    // 2. Menampilkan Riwayat Rental Customer
    public function history()
    {
        $bookings = Booking::with(['vehicle.brand', 'payment'])
            ->where('user_id', Auth::id())
            ->whereIn('status', [Booking::STATUS_COMPLETED, Booking::STATUS_REJECTED, Booking::STATUS_CANCELLED])
            ->latest()
            ->paginate(10);

        return view('customer.bookings.history', compact('bookings'));
    }

    // 3. Menampilkan Form Booking Kendaraan (Programmer B View)
    public function create($vehicle_id)
    {
        $vehicle = Vehicle::with(['brand', 'category', 'type'])
            ->where('status', 'available')
            ->findOrFail($vehicle_id);

        $setting = Setting::first();

        return view('customer.bookings.create', compact('vehicle', 'setting'));
    }

    // 4. Menyimpan Transaksi Booking Baru
    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after:start_date',
            'notes'      => 'nullable|string|max:500',
        ], [
            'start_date.after_or_equal' => 'Tanggal mulai rental tidak boleh di masa lalu.',
            'end_date.after'            => 'Tanggal selesai harus setelah tanggal mulai sewa.',
        ]);

        $vehicle = Vehicle::findOrFail($request->vehicle_id);

        // Pastikan Kendaraan Masih Available
        if ($vehicle->status !== 'available') {
            return back()->withErrors(['vehicle_id' => 'Maaf, kendaraan ini sedang tidak tersedia untuk disewa.']);
        }

        // Perhitungan Durasi Hari & Total Biaya
        $startDate = Carbon::parse($request->start_date);
        $endDate   = Carbon::parse($request->end_date);
        
        // Hitung selisih hari (minimal 1 hari)
        $durationDays = max(1, $startDate->diffInDays($endDate));
        
        $pricePerDay = $vehicle->price_per_day;
        $subtotal    = $pricePerDay * $durationDays;
        $discount    = 0; // Dapat diintegrasikan dengan promo pada sprint berikutnya
        $totalPrice  = $subtotal - $discount;

        // Generate Nomor Invoice Otomatis via Service (Programmer D Service)
        $invoiceNumber = InvoiceService::generate();

        // Simpan ke Database Table bookings
        $booking = Booking::create([
            'invoice_number' => $invoiceNumber,
            'user_id'        => Auth::id(),
            'vehicle_id'     => $vehicle->id,
            'start_date'     => $startDate,
            'end_date'       => $endDate,
            'duration_days'  => $durationDays,
            'price_per_day'  => $pricePerDay,
            'subtotal'       => $subtotal,
            'discount'       => $discount,
            'total_price'    => $totalPrice,
            'status'         => Booking::STATUS_PENDING,
            'notes'          => $request->notes,
        ]);

        // Redirect langsung ke Halaman Invoice
        return redirect()->route('customer.bookings.show', $booking->id)
            ->with('success', 'Booking berhasil dibuat! Silakan konfirmasi pembayaran via WhatsApp.');
    }

    // 5. Menampilkan Detail Invoice Booking (Programmer D View)
    public function show($id)
    {
        $booking = Booking::with(['vehicle.brand', 'vehicle.category', 'user', 'payment'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $setting = Setting::first();

        return view('customer.bookings.show', compact('booking', 'setting'));
    }

    public function downloadPdf($id)
    {
        $booking = Booking::with(['vehicle.brand', 'vehicle.category', 'user'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $setting = Setting::first();

        // Generate PDF menggunakan view khusus PDF
        $pdf = Pdf::loadView('customer.bookings.pdf', compact('booking', 'setting'));

        return $pdf->download('Invoice-' . $booking->invoice_number . '.pdf');
    }
}