@extends('layouts.admin')

@section('title', 'Admin Dashboard - RentRide')
@section('page_title', 'Ringkasan Dashboard Admin')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase">Total Armada</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-1">125</h3>
            <p class="text-xs text-emerald-600 font-medium mt-1"><i class="fa-solid fa-arrow-up"></i> 12 Tersedia</p>
        </div>
        <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center text-xl">
            <i class="fa-solid fa-car-side"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase">Booking Hari Ini</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-1">15</h3>
            <p class="text-xs text-amber-600 font-medium mt-1"><i class="fa-solid fa-clock"></i> 4 Butuh Aksi</p>
        </div>
        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-xl">
            <i class="fa-solid fa-calendar-check"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase">Customer Aktif</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-1">89</h3>
            <p class="text-xs text-slate-500 mt-1">Pengguna Terdaftar</p>
        </div>
        <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center text-xl">
            <i class="fa-solid fa-users"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase">Pendapatan Bulan Ini</p>
            <h3 class="text-xl font-bold text-slate-800 mt-1">Rp 10.000.000</h3>
            <p class="text-xs text-emerald-600 font-medium mt-1"><i class="fa-solid fa-arrow-up"></i> +18% dari lalu</p>
        </div>
        <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center text-xl">
            <i class="fa-solid fa-wallet"></i>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-base font-bold text-slate-800">Booking Terbaru Perlu Verifikasi</h3>
        <a href="#" class="text-xs font-semibold text-amber-600 hover:underline">Lihat Semua &rarr;</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs font-semibold">
                    <th class="p-3">INVOICE</th>
                    <th class="p-3">CUSTOMER</th>
                    <th class="p-3">ARMADA</th>
                    <th class="p-3">TOTAL</th>
                    <th class="p-3">STATUS</th>
                    <th class="p-3 text-center">AKSI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                <tr>
                    <td class="p-3 font-semibold text-amber-600">INV20260704001</td>
                    <td class="p-3">Budi Santoso</td>
                    <td class="p-3">Toyota Alphard 2024</td>
                    <td class="p-3 font-medium">Rp 1.500.000</td>
                    <td class="p-3"><span class="px-2.5 py-1 bg-amber-100 text-amber-700 text-xs font-semibold rounded-full">Menunggu Verifikasi</span></td>
                    <td class="p-3 text-center">
                        <button class="bg-slate-900 text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-slate-800">Detail</button>
                    </td>
                </tr>
                <tr>
                    <td class="p-3 font-semibold text-amber-600">INV20260704002</td>
                    <td class="p-3">Siti Rahma</td>
                    <td class="p-3">Honda NMAX Turbo 2025</td>
                    <td class="p-3 font-medium">Rp 300.000</td>
                    <td class="p-3"><span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-full">Disetujui</span></td>
                    <td class="p-3 text-center">
                        <button class="bg-slate-900 text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-slate-800">Detail</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection