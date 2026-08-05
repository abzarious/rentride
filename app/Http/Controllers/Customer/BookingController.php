<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Setting;
use App\Enums\VehicleStatus;
use App\Services\BookingAvailabilityService;
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
        $bookings = Booking::with(['vehicle.brand', 'vehicle.category'])
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'approved', 'ongoing'])
            ->latest()
            ->paginate(10);

        return view('customer.bookings.index', compact('bookings'));
    }

    // 2. Menampilkan Riwayat Rental Customer
    public function history()
    {
        $bookings = Booking::with(['vehicle.brand', 'vehicle.category'])
            ->where('user_id', Auth::id())
            ->whereIn('status', ['completed', 'rejected', 'cancelled'])
            ->latest()
            ->paginate(10);

        return view('customer.bookings.history', compact('bookings'));
    }

    // 3. Menampilkan Form Booking
    public function create($vehicle_id)
    {
        $vehicle = Vehicle::with(['brand', 'category', 'vehicleType'])
            ->where('status', VehicleStatus::AVAILABLE->value)
            ->findOrFail($vehicle_id);

        $setting = Setting::first();

        return view('customer.bookings.create', compact('vehicle', 'setting'));
    }

    // 4. Menyimpan Booking & Perhitungan Biaya Otomatis (Aman)
    public function store(Request $request)
    {
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

        // PERBAIKAN BUG ENUM CHECK:
        // Cek status enum dengan aman
        $statusValue = $vehicle->status instanceof VehicleStatus 
            ? $vehicle->status->value 
            : $vehicle->status;

        if ($statusValue !== 'available') {
            return back()->withErrors(['vehicle_id' => 'Maaf, kendaraan ini sedang tidak dalam status tersedia.']);
        }

        // Cek bentrokan tanggal sewa dengan customer lain
        $isAvailable = BookingAvailabilityService::isAvailable(
            $vehicle->id,
            $request->start_date,
            $request->end_date
        );

        if (!$isAvailable) {
            return back()->withErrors(['start_date' => 'Maaf, kendaraan sudah dibooking pada rentang tanggal tersebut. Silakan pilih tanggal lain.']);
        }

        // LOGIKA PERHITUNGAN BIAYA DI BACKEND
        $start = Carbon::parse($request->start_date);
        $end   = Carbon::parse($request->end_date);

        $diffHours = $start->diffInHours($end);
        $durationDays = (int) ceil($diffHours / 24);
        if ($durationDays < 1) $durationDays = 1;

        $pricePerDay = $vehicle->price_per_day;
        $subtotal    = $pricePerDay * $durationDays;
        $adminFee    = 5000; // Biaya Admin Layanan
        $discount    = 0;    // Promo / Diskon
        $totalPrice  = $subtotal + $adminFee - $discount;

        $invoiceNumber = InvoiceService::generate();

        // Simpan Transaksi Booking
        $booking = Booking::create([
            'invoice_number' => $invoiceNumber,
            'user_id'        => Auth::id(),
            'vehicle_id'     => $vehicle->id,
            'start_date'     => $start,
            'end_date'       => $end,
            'duration_days'  => $durationDays,
            'price_per_day'  => $pricePerDay,
            'subtotal'       => $subtotal,
            'admin_fee'      => $adminFee,
            'discount'       => $discount,
            'total_price'    => $totalPrice,
            'status'         => 'pending',
            'notes'          => $request->notes,
        ]);

        return redirect()->route('customer.bookings.show', $booking->id)
            ->with('success', 'Booking berhasil dibuat! Silakan konfirmasi pembayaran via WhatsApp.');
    }

    // 5. Menampilkan Detail Invoice Booking
    public function show($id)
    {
        $booking = Booking::with(['vehicle.brand', 'vehicle.category', 'user'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $setting = Setting::first();

        return view('customer.bookings.show', compact('booking', 'setting'));
    }

    // 6. Preview Invoice
    public function previewInvoice($id)
    {
        $booking = Booking::with(['vehicle.brand', 'vehicle.category', 'user'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $setting = Setting::first();

        return view('customer.bookings.preview-invoice', compact('booking', 'setting'));
    }

    // 7. Download Invoice PDF
    public function downloadPdf($id)
    {
        $booking = Booking::with(['vehicle.brand', 'vehicle.category', 'user'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $setting = Setting::first();

        $pdf = Pdf::loadView('customer.bookings.pdf', compact('booking', 'setting'));

        return $pdf->download('Invoice-' . $booking->invoice_number . '.pdf');
    }
}