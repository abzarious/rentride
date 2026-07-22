<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'rental_aktif' => 1,
            'riwayat_rental' => 8,
            'wishlist' => 3,
        ];

        return view('customer.dashboard', compact('stats'));
    }
}