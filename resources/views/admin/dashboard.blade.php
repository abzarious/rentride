@extends('layouts.admin')

@section('title', 'Admin Dashboard - RentRide')
@section('page_title', 'Dashboard Utama Admin')

@section('content')
<div class="mb-6 bg-slate-900 text-white p-6 rounded-2xl shadow-sm flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
        <p class="text-xs text-slate-400 mt-1">Sistem Rental Mobil & Motor siap digunakan. Email: {{ auth()->user()->email }}</p>
    </div>
    <span class="px-3 py-1 bg-amber-500/20 border border-amber-500 text-amber-400 text-xs font-bold rounded-full uppercase">
        Role: {{ auth()->user()->role }}
    </span>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase">Total Kendaraan</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($stats['total_kendaraan']) }}</h3>
            <p class="text-xs text-emerald-600 font-medium mt-1"><i class="fa-solid fa-check-circle"></i> Mobil & Motor</p>
        </div>
        <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center text-xl">
            <i class="fa-solid fa-car-side"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase">Booking Hari Ini</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['booking_hari_ini'] }}</h3>
            <p class="text-xs text-amber-600 font-medium mt-1"><i class="fa-solid fa-clock"></i> Membutuhkan Respon</p>
        </div>
        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-xl">
            <i class="fa-solid fa-calendar-check"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase">Total Customer</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['total_customer'] }}</h3>
            <p class="text-xs text-slate-500 mt-1">Terdaftar di Aplikasi</p>
        </div>
        <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center text-xl">
            <i class="fa-solid fa-users"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase">Pendapatan</p>
            <h3 class="text-lg font-bold text-slate-800 mt-1">Rp {{ number_format($stats['total_pendapatan'], 0, ',', '.') }}</h3>
            <p class="text-xs text-emerald-600 font-medium mt-1"><i class="fa-solid fa-arrow-up"></i> Estimasi Bulanan</p>
        </div>
        <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center text-xl">
            <i class="fa-solid fa-wallet"></i>
        </div>
    </div>
</div>
@endsection