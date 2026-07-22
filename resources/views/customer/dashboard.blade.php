@extends('layouts.customer')

@section('title', 'Dashboard Customer - RentRide')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="bg-gradient-to-r from-[#111827] via-slate-900 to-[#111827] border border-[#D97706]/40 p-8 rounded-2xl shadow-xl mb-8 flex flex-col md:flex-row items-center justify-between gap-6">
        <div>
            <span class="text-xs font-bold text-[#D97706] uppercase tracking-widest">Panel Pelanggan</span>
            <h1 class="text-3xl font-extrabold text-white mt-1">Selamat Datang, {{ auth()->user()->name }}! ✨</h1>
            <p class="text-sm text-gray-400 mt-2">Email: {{ auth()->user()->email }} | No. Telp: {{ auth()->user()->phone ?? 'Belum diisi' }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('customer.profile.index') }}" class="px-5 py-2.5 bg-[#111827] border border-[#D97706] text-[#D97706] font-bold rounded-xl hover:bg-[#D97706] hover:text-slate-950 transition">
                <i class="fa-solid fa-id-card mr-1"></i> Edit Profil
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-[#111827] p-6 rounded-xl border border-gray-800 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase">Rental Aktif</p>
                <h3 class="text-3xl font-bold text-white mt-1">{{ $stats['rental_aktif'] }}</h3>
                <p class="text-xs text-[#059669] font-medium mt-1">Toyota Fortuner VRZ</p>
            </div>
            <div class="w-12 h-12 bg-emerald-950 text-[#059669] border border-emerald-600/30 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-key"></i>
            </div>
        </div>

        <div class="bg-[#111827] p-6 rounded-xl border border-gray-800 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase">Riwayat Rental</p>
                <h3 class="text-3xl font-bold text-white mt-1">{{ $stats['riwayat_rental'] }}</h3>
                <p class="text-xs text-gray-400 mt-1">Selesai Berhasil</p>
            </div>
            <div class="w-12 h-12 bg-amber-950 text-[#D97706] border border-amber-600/30 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
        </div>

        <div class="bg-[#111827] p-6 rounded-xl border border-gray-800 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase">Wishlist</p>
                <h3 class="text-3xl font-bold text-white mt-1">{{ $stats['wishlist'] }}</h3>
                <p class="text-xs text-gray-400 mt-1">Kendaraan Favorit</p>
            </div>
            <div class="w-12 h-12 bg-red-950 text-red-400 border border-red-600/30 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-heart"></i>
            </div>
        </div>
    </div>

</div>
@endsection