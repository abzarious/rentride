<?php

namespace App\Services;

use Carbon\Carbon;
use InvalidArgumentException;

class RentalDurationService
{
    /**
     * Menghitung total hari penyewaan berdasarkan tanggal mulai dan tanggal selesai.
     */
    public static function calculateDays(string $startDate, string $endDate, int $minDays = 1): int
    {
        $start = Carbon::parse($startDate);
        $end   = Carbon::parse($endDate);

        if ($end->lessThanOrEqualTo($start)) {
            throw new InvalidArgumentException('Tanggal selesai harus setelah tanggal mulai sewa.');
        }

        // Hitung selisih jam, konversi ke hari (dibulatkan ke atas jika ada sisa jam)
        $diffInHours = $start->diffInHours($end);
        $calculatedDays = (int) ceil($diffInHours / 24);

        return max($minDays, $calculatedDays);
    }

    /**
     * Menghitung estimasi total biaya sewa
     */
    public static function calculateTotalBiaya(int $pricePerDay, int $durationDays, int $discount = 0): array
    {
        $subtotal = $pricePerDay * $durationDays;
        $total = max(0, $subtotal - $discount);

        return [
            'price_per_day' => $pricePerDay,
            'duration_days' => $durationDays,
            'subtotal'      => $subtotal,
            'discount'      => $discount,
            'total'         => $total,
        ];
    }
}