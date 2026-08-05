<?php

namespace App\Services;

use Carbon\Carbon;

class PriceService
{
    /**
     * Menghitung durasi sewa dalam hari (pembulatan ke atas)
     */
    public function calculateDurationDays(string $startDate, string $endDate): int
    {
        $start = Carbon::parse($startDate);
        $end   = Carbon::parse($endDate);

        $diffHours = $start->diffInHours($end);
        $days = (int) ceil($diffHours / 24);

        return max(1, $days);
    }

    /**
     * Menghitung rincian biaya rental lengkap
     */
    public function calculatePriceDetails(int $pricePerDay, int $durationDays, int $discount = 0, int $adminFee = 5000): array
    {
        $subtotal   = $pricePerDay * $durationDays;
        $totalPrice = max(0, ($subtotal + $adminFee) - $discount);

        return [
            'price_per_day' => $pricePerDay,
            'duration_days' => $durationDays,
            'subtotal'      => $subtotal,
            'admin_fee'     => $adminFee,
            'discount'      => $discount,
            'total_price'   => $totalPrice,
        ];
    }
}