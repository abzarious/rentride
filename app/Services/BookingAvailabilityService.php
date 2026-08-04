<?php

namespace App\Services;

use App\Models\Booking;
use Carbon\Carbon;

class BookingAvailabilityService
{
    /**
     * Mengecek apakah kendaraan ID tertentu TERSEDIA pada rentang tanggal [startDate, endDate]
     */
    public static function isAvailable(int $vehicleId, string $startDate, string $endDate, ?int $ignoreBookingId = null): bool
    {
        $start = Carbon::parse($startDate);
        $end   = Carbon::parse($endDate);

        $query = Booking::where('vehicle_id', $vehicleId)
            // Abaikan booking yang sudah dibatalkan atau ditolak
            ->whereNotIn('status', [Booking::STATUS_REJECTED, Booking::STATUS_CANCELLED])
            // Overlapping condition: (existing_start < new_end) AND (existing_end > new_start)
            ->where(function ($q) use ($start, $end) {
                $q->where('start_date', '<', $end)
                  ->where('end_date', '>', $start);
            });

        if ($ignoreBookingId) {
            $query->where('id', '!=', $ignoreBookingId);
        }

        return !$query->exists(); // Return true jika TIDAK ada booking bertabrakan
    }

    /**
     * Mengambil daftar tanggal yang sudah dibooking untuk disable di kalender
     */
    public static function getBookedDateRanges(int $vehicleId): array
    {
        $bookings = Booking::where('vehicle_id', $vehicleId)
            ->whereNotIn('status', [Booking::STATUS_REJECTED, Booking::STATUS_CANCELLED])
            ->where('end_date', '>=', now())
            ->get(['start_date', 'end_date']);

        $ranges = [];
        foreach ($bookings as $b) {
            $ranges[] = [
                'from' => $b->start_date->format('Y-m-d H:i'),
                'to'   => $b->end_date->format('Y-m-d H:i'),
            ];
        }

        return $ranges;
    }
}