<?php

namespace App\Services;

use Carbon\Carbon;

class PenaltyService
{
    /**
     * Menghitung denda keterlambatan berdasarkan selisih waktu jadwal dan aktual
     *
     * @param string|\DateTimeInterface $expectedReturn Waktu seharusnya dikembalikan ($booking->end_date)
     * @param string|\DateTimeInterface $actualReturn   Waktu aktual dikembalikan (now / $booking->checked_in_at)
     * @param int $ratePerHour Rate denda per jam (Default: Rp 10.000 / jam)
     * @return array
     */
    public function calculate($expectedReturn, $actualReturn = null, int $ratePerHour = 10000): array
    {
        $expected = Carbon::parse($expectedReturn);
        $actual   = $actualReturn ? Carbon::parse($actualReturn) : Carbon::now();

        // Jika dikembalikan lebih awal atau tepat waktu -> Tidak ada denda
        if ($actual->lessThanOrEqualTo($expected)) {
            return [
                'is_late'        => false,
                'late_minutes'   => 0,
                'late_hours'     => 0,
                'penalty_amount' => 0,
            ];
        }

        // Hitung total selisih menit keterlambatan
        $lateMinutes = $expected->diffInMinutes($actual);

        // Pembulatan jam ke atas (Misal: terlambat 1 jam 10 menit = 2 jam)
        $lateHours = (int) ceil($lateMinutes / 60);

        // Total nominal denda
        $penaltyAmount = $lateHours * $ratePerHour;

        return [
            'is_late'        => true,
            'late_minutes'   => $lateMinutes,
            'late_hours'     => $lateHours,
            'penalty_amount' => $penaltyAmount,
        ];
    }
}