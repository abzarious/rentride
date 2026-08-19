<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Report\RevenueReportRequest;
use App\Models\Payment;
use App\Services\ActivityLogService;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    protected ActivityLogService $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    /**
     * Menampilkan Halaman Laporan Pendapatan di Web
     */
    public function revenue(RevenueReportRequest $request): View
    {
        $filters = $request->validated();

        // Ringkasan Finansial Real-time
        $todayRevenue = Payment::query()
            ->whereIn('status', ['verified', 'approved', 'paid'])
            ->whereDate('created_at', Carbon::today())
            ->sum('amount');

        $weekRevenue = Payment::query()
            ->whereIn('status', ['verified', 'approved', 'paid'])
            ->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek(),
            ])
            ->sum('amount');

        $monthRevenue = Payment::query()
            ->whereIn('status', ['verified', 'approved', 'paid'])
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');

        // Query Filter Data Transaksi
        $query = Payment::query()
            ->whereIn('status', ['verified', 'approved', 'paid']);

        if (! empty($filters['start_date'])) {
            $query->whereDate('created_at', '>=', $filters['start_date']);
        }

        if (! empty($filters['end_date'])) {
            $query->whereDate('created_at', '<=', $filters['end_date']);
        }

        if (! empty($filters['month'])) {
            $query->whereMonth('created_at', $filters['month']);
        }

        if (! empty($filters['year'])) {
            $query->whereYear('created_at', $filters['year']);
        }

        $totalRevenue = (clone $query)->sum('amount');

        $payments = $query->with(['booking.user', 'booking.vehicle'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.reports.revenue.index', compact(
            'todayRevenue',
            'weekRevenue',
            'monthRevenue',
            'totalRevenue',
            'payments',
            'filters'
        ));
    }

    /**
     * FITUR TAMBAHAN: Cetak / Export PDF Laporan Pendapatan
     */
    public function downloadPdf(RevenueReportRequest $request)
    {
        $filters = $request->validated();

        // Build Query yang sama persis dengan Tampilan Web
        $query = Payment::query()
            ->whereIn('status', ['verified', 'approved', 'paid']);

        if (! empty($filters['start_date'])) {
            $query->whereDate('created_at', '>=', $filters['start_date']);
        }

        if (! empty($filters['end_date'])) {
            $query->whereDate('created_at', '<=', $filters['end_date']);
        }

        if (! empty($filters['month'])) {
            $query->whereMonth('created_at', $filters['month']);
        }

        if (! empty($filters['year'])) {
            $query->whereYear('created_at', $filters['year']);
        }

        $totalRevenue = (clone $query)->sum('amount');

        // Ambil SEMUA data tanpa pagination untuk dicetak ke PDF
        $payments = $query->with(['booking.user', 'booking.vehicle'])
            ->latest()
            ->get();

        $setting = \App\Models\Setting::first();

        // Catat Aktivitas Ekspor PDF ke Activity Log (Programmer D)
        $this->activityLogService->log(
            'EXPORT_REVENUE_PDF',
            "Admin " . auth()->user()->name . " mengunduh Laporan Pendapatan format PDF.",
            Payment::class
        );

        // Render PDF menggunakan view khusus
        $pdf = Pdf::loadView('admin.reports.revenue.pdf', compact(
            'payments',
            'totalRevenue',
            'filters',
            'setting'
        ))->setPaper('a4', 'portrait');

        $filename = 'Laporan_Pendapatan_RentRide_' . date('Ymd_His') . '.pdf';

        return $pdf->download($filename);
    }
}