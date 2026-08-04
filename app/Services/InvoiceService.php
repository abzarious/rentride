<?php

namespace App\Services;

use App\Models\Booking;
use Carbon\Carbon;

class InvoiceService
{
    /**
     * Generate Nomor Invoice Unik & Automatis
     * Format: INV + YYYYMMDD + 0001
     * Example: INV202608040001
     */
    public static function generate(): string
    {
        $today = Carbon::now();
        $datePrefix = 'INV' . $today->format('Ymd'); // Contoh: INV20260804

        // Hitung total booking yang dibuat hari ini
        $countToday = Booking::whereDate('created_at', $today->toDateString())->count();
        
        $sequence = str_pad($countToday + 1, 4, '0', STR_PAD_LEFT);
        $invoiceNumber = $datePrefix . $sequence;

        // Validasi Duplikasi untuk Memastikan Unik 100%
        while (Booking::where('invoice_number', $invoiceNumber)->exists()) {
            $countToday++;
            $sequence = str_pad($countToday + 1, 4, '0', STR_PAD_LEFT);
            $invoiceNumber = $datePrefix . $sequence;
        }

        return $invoiceNumber;
    }
}