<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Setting;
use App\Enums\VehicleStatus;
use App\Services\BookingService;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingController extends Controller
{
    protected BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index()
    {
        $bookings = Booking::with(['vehicle.brand', 'vehicle.category'])
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'approved', 'ongoing'])
            ->latest()
            ->paginate(9);

        return view('customer.bookings.index', compact('bookings'));
    }

    public function history()
    {
        $bookings = Booking::with(['vehicle.brand', 'vehicle.category'])
            ->where('user_id', Auth::id())
            ->whereIn('status', ['completed', 'rejected', 'cancelled'])
            ->latest()
            ->paginate(10);

        return view('customer.bookings.history', compact('bookings'));
    }

    public function create($vehicle_id)
    {
        $vehicle = Vehicle::with(['brand', 'category', 'vehicleType'])
            ->where('status', VehicleStatus::AVAILABLE->value)
            ->findOrFail($vehicle_id);

        $setting = Setting::first();

        return view('customer.bookings.create', compact('vehicle', 'setting'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after:start_date',
            'notes'      => 'nullable|string|max:500',
        ]);

        try {
            $booking = $this->bookingService->createBooking($request->all(), Auth::id());

            return redirect()->route('customer.bookings.success', $booking->id);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // Halaman Konfirmasi Booking Berhasil (Jobdesk B)
    public function success($id)
    {
        $booking = Booking::with(['vehicle.brand', 'vehicle.category', 'user'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $setting = Setting::first();
        $whatsappUrl = WhatsAppService::generateBookingUrl($booking, $setting);

        return view('customer.bookings.success', compact('booking', 'setting', 'whatsappUrl'));
    }

    public function show($id)
    {
        $booking = Booking::with(['vehicle.brand', 'vehicle.category', 'user'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $setting = Setting::first();
        $whatsappUrl = WhatsAppService::generateBookingUrl($booking, $setting);

        return view('customer.bookings.show', compact('booking', 'setting', 'whatsappUrl'));
    }

    public function previewInvoice($id)
    {
        $booking = Booking::with(['vehicle.brand', 'vehicle.category', 'user'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $setting = Setting::first();

        return view('customer.bookings.preview-invoice', compact('booking', 'setting'));
    }

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