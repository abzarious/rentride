<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data ringkasan statistik (Dummy sebelum tabel transaksi dibuat)
        $stats = [
            'total_kendaraan' => 125,
            'booking_hari_ini' => 15,
            'total_customer'  => 89,
            'total_pendapatan' => 10000000,
        ];

        return view('admin.dashboard', compact('stats'));
    }
}