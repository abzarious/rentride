@extends('layouts.customer')

@section('title', 'Dashboard Customer - RentRide')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <div class="bg-gradient-to-r from-[#111827] via-slate-900 to-[#111827] border border-[#D97706]/40 p-8 rounded-2xl shadow-xl mb-10 flex flex-col md:flex-row items-center justify-between gap-6">
        <div>
            <span class="text-xs font-bold text-[#D97706] uppercase tracking-widest">Selamat Datang Kembali</span>
            <h1 class="text-3xl font-extrabold text-white mt-1">Halo, {{ Auth::user()->name ?? 'Pelanggan Setia' }}!</h1>
            <p class="text-sm text-gray-400 mt-2">Kelola transaksi penyewaan armada eksklusif dan cek status reservasi Anda di sini.</p>
        </div>
        <a href="#" class="px-6 py-3 bg-[#D97706] text-slate-950 font-bold rounded-xl hover:bg-amber-500 transition shadow-lg shadow-amber-600/20 whitespace-nowrap">
            <i class="fa-solid fa-car-side mr-2"></i> Sewa Kendaraan Baru
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-[#111827] p-6 rounded-xl border border-gray-800 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase">Rental Berjalan</p>
                <h3 class="text-3xl font-bold text-white mt-1">1</h3>
                <p class="text-xs text-[#059669] font-medium mt-1">Toyota Fortuner VRZ</p>
            </div>
            <div class="w-12 h-12 bg-emerald-950 text-[#059669] border border-emerald-600/30 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-[#059669] fa-key"></i>
            </div>
        </div>

        <div class="bg-[#111827] p-6 rounded-xl border border-gray-800 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase">Riwayat Rental</p>
                <h3 class="text-3xl font-bold text-white mt-1">8</h3>
                <p class="text-xs text-gray-400 mt-1">Selesai Tanpa Kendala</p>
            </div>
            <div class="w-12 h-12 bg-amber-950 text-[#D97706] border border-amber-600/30 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
        </div>

        <div class="bg-[#111827] p-6 rounded-xl border border-gray-800 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase">Wishlist</p>
                <h3 class="text-3xl font-bold text-white mt-1">3</h3>
                <p class="text-xs text-gray-400 mt-1">Kendaraan Impian Anda</p>
            </div>
            <div class="w-12 h-12 bg-red-950 text-red-400 border border-red-600/30 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-heart"></i>
            </div>
        </div>
    </div>

    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6">
        <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
            <i class="fa-solid fa-circle-dot text-[#059669]"></i> Rental Yang Sedang Aktif
        </h3>
        
        <div class="bg-[#030712] p-6 rounded-xl border border-gray-800 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-20 h-20 bg-gray-800 rounded-lg flex items-center justify-center text-3xl text-gray-500">
                    <i class="fa-solid fa-car"></i>
                </div>
                <div>
                    <span class="px-2.5 py-0.5 bg-emerald-950 text-[#059669] border border-emerald-600 text-xs font-bold rounded-full">Status: Sedang Dirental</span>
                    <h4 class="text-lg font-bold text-white mt-2">Toyota Fortuner VRZ 2025</h4>
                    <p class="text-xs text-gray-400 mt-1"><i class="fa-regular fa-calendar"></i> Selesai: 07 Juli 2026 (12:00 WIB)</p>
                </div>
            </div>
            <div class="flex gap-3 w-full md:w-auto">
                <a href="#" class="flex-1 md:flex-none text-center px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-500 transition">
                    <i class="fa-brands fa-whatsapp mr-1"></i> Hubungi Admin
                </a>
                <a href="#" class="flex-1 md:flex-none text-center px-4 py-2 bg-gray-800 text-gray-200 border border-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">
                    Cek Invoice
                </a>
            </div>
        </div>
    </div>

</div>
@endsection