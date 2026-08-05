<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Setting;

class WhatsAppService
{
    public static function generateBookingUrl(Booking $booking, ?Setting $setting = null): string
    {
        if (!$setting) {
            $setting = Setting::first();
        }

        $rawPhone = $setting->whatsapp ?? '6281234567890';
        $phone = preg_replace('/[^0-9]/', '', $rawPhone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        $companyName = $setting->company_name ?? 'RentRide';

        $message  = "Halo Admin *" . $companyName . "* 👋,\n\n";
        $message .= "Saya baru saja membuat booking rental online dengan rincian:\n\n";
        $message .= "🧾 *DATA PEMESANAN*\n";
        $message .= "• No. Invoice: *" . $booking->invoice_number . "*\n";
        $message .= "• Nama Penyewa: *" . ($booking->user->name ?? 'Customer') . "*\n";
        $message .= "• Armada: *" . ($booking->vehicle->name ?? '-') . "* (Plat: " . ($booking->vehicle->plate_number ?? '-') . ")\n";
        $message .= "• Tanggal Sewa: " . $booking->start_date->format('d/m/Y H:i') . " s/d " . $booking->end_date->format('d/m/Y H:i') . "\n";
        $message .= "• Durasi: *" . $booking->duration_days . " Hari*\n";
        $message .= "• Total Tagihan: *Rp " . number_format($booking->total_price, 0, ',', '.') . "*\n\n";
        $message .= "Mohon bantuannya untuk verifikasi pesanan ini. Terima kasih! 🙏";

        return "https://wa.me/" . $phone . "?text=" . urlencode($message);
    }
}