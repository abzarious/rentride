@extends('layouts.admin')

@section('title', 'Admin Dashboard - RentRide')
@section('page_title', 'Dashboard Utama Admin')

@section('content')
<div class="mb-6 bg-slate-900 text-white p-6 rounded-2xl shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
        <p class="text-xs text-slate-400 mt-1">Sistem Rental Mobil & Motor siap digunakan. Email: {{ auth()->user()->email }}</p>
    </div>
    <div class="flex items-center gap-3">
        <span class="px-3 py-1 bg-amber-500/20 border border-amber-500 text-amber-400 text-xs font-bold rounded-full uppercase">
            Role: {{ auth()->user()->role }}
        </span>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition flex items-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase">Total Kendaraan</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($stats['total_kendaraan'] ?? 125) }}</h3>
            <p class="text-xs text-emerald-600 font-medium mt-1"><i class="fa-solid fa-check-circle"></i> Mobil & Motor</p>
        </div>
        <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center text-xl">
            <i class="fa-solid fa-car-side"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase">Booking Hari Ini</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['booking_hari_ini'] ?? 15 }}</h3>
            <p class="text-xs text-amber-600 font-medium mt-1"><i class="fa-solid fa-clock"></i> Membutuhkan Respon</p>
        </div>
        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-xl">
            <i class="fa-solid fa-calendar-check"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase">Total Customer</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['total_customer'] ?? 89 }}</h3>
            <p class="text-xs text-slate-500 mt-1">Terdaftar di Aplikasi</p>
        </div>
        <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center text-xl">
            <i class="fa-solid fa-users"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase">Pendapatan</p>
            <h3 class="text-lg font-bold text-slate-800 mt-1">Rp {{ number_format($stats['total_pendapatan'] ?? 10000000, 0, ',', '.') }}</h3>
            <p class="text-xs text-emerald-600 font-medium mt-1"><i class="fa-solid fa-arrow-up"></i> Estimasi Bulanan</p>
        </div>
        <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center text-xl">
            <i class="fa-solid fa-wallet"></i>
        </div>
    </div>
</div>

<h3 class="text-base font-bold text-slate-800 mb-3">Contoh Integrasi Reusable Table & Badge Component</h3>
<x-tables.table>
    <x-slot name="head">
        <tr>
            <th class="p-3">INVOICE</th>
            <th class="p-3">PELANGGAN</th>
            <th class="p-3">STATUS</th>
            <th class="p-3 text-right">AKSI</th>
        </tr>
    </x-slot>
    <x-slot name="body">
        <tr>
            <td class="p-3 font-semibold text-amber-500">INV202607001</td>
            <td class="p-3">Budi Santoso</td>
            <td class="p-3"><x-badges.status-badge status="booked" /></td>
            <td class="p-3 text-right">
                <x-buttons.primary-button class="!py-1 !px-3 !text-xs inline-flex">Detail</x-buttons.primary-button>
            </td>
        </tr>
    </x-slot>
</x-tables.table>
@endsection