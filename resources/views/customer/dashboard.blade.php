@extends('layouts.customer')

@section('title', 'Dashboard Customer - RentRide')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="bg-gradient-to-r from-[#111827] via-slate-900 to-[#111827] border border-[#D97706]/40 p-8 rounded-2xl shadow-xl mb-8 flex flex-col md:flex-row items-center justify-between gap-6">
        <div>
            <span class="text-xs font-bold text-[#D97706] uppercase tracking-widest">Panel Pelanggan</span>
            <h1 class="text-3xl font-extrabold text-white mt-1">Selamat Datang, {{ auth()->user()->name }}! ✨</h1>
            <p class="text-sm text-gray-400 mt-2">Email: {{ auth()->user()->email }} | Telp: {{ auth()->user()->phone ?? 'Belum diisi' }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('customer.profile.index') }}" class="px-5 py-2.5 bg-[#111827] border border-[#D97706] text-[#D97706] font-bold rounded-xl hover:bg-[#D97706] hover:text-slate-950 transition text-sm flex items-center gap-1.5">
                <i class="fa-solid fa-id-card"></i> Profil Saya
            </a>
            <a href="{{ url('/#katalog') }}" class="px-5 py-2.5 bg-[#D97706] text-slate-950 font-extrabold rounded-xl hover:bg-amber-500 transition text-sm flex items-center gap-1.5 shadow-lg shadow-amber-600/20">
                <i class="fa-solid fa-car"></i> Sewa Armada
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-[#111827] p-6 rounded-xl border border-gray-800 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase">Rental Aktif</p>
                <h3 class="text-3xl font-bold text-white mt-1">{{ $stats['active'] }}</h3>
                <p class="text-[10px] text-emerald-400 mt-1">Berjalan & Disetujui</p>
            </div>
            <div class="w-12 h-12 bg-emerald-950 text-[#059669] border border-emerald-600/30 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-key"></i>
            </div>
        </div>

        <div class="bg-[#111827] p-6 rounded-xl border border-gray-800 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase">Menunggu WA</p>
                <h3 class="text-3xl font-bold text-white mt-1">{{ $stats['pending'] }}</h3>
                <p class="text-[10px] text-amber-400 mt-1">Pending Verifikasi</p>
            </div>
            <div class="w-12 h-12 bg-amber-950 text-[#D97706] border border-amber-600/30 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-clock"></i>
            </div>
        </div>

        <div class="bg-[#111827] p-6 rounded-xl border border-gray-800 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase">Selesai</p>
                <h3 class="text-3xl font-bold text-white mt-1">{{ $stats['completed'] }}</h3>
                <p class="text-[10px] text-blue-400 mt-1">Riwayat Selesai</p>
            </div>
            <div class="w-12 h-12 bg-blue-950 text-blue-400 border border-blue-600/30 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>

        <div class="bg-[#111827] p-6 rounded-xl border border-gray-800 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase">Dibatalkan</p>
                <h3 class="text-3xl font-bold text-white mt-1">{{ $stats['cancelled'] }}</h3>
                <p class="text-[10px] text-red-400 mt-1">Rejected / Cancelled</p>
            </div>
            <div class="w-12 h-12 bg-red-950 text-red-400 border border-red-600/30 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-ban"></i>
            </div>
        </div>
    </div>

    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-xl mb-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-white">Transaksi Booking Terbaru</h3>
            <a href="{{ route('customer.bookings.index') }}" class="text-xs text-[#D97706] hover:underline font-bold">
                Lihat Semua <i class="fa-solid fa-arrow-right ml-1"></i>
            </a>
        </div>

        @if($recentBookings->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left text-gray-300">
                    <thead class="bg-[#030712] text-gray-400 uppercase text-[10px] border-b border-gray-800">
                        <tr>
                            <th class="p-3">INVOICE</th>
                            <th class="p-3">KENDARAAN</th>
                            <th class="p-3">MULAI</th>
                            <th class="p-3">SELESAI</th>
                            <th class="p-3">TOTAL</th>
                            <th class="p-3">STATUS</th>
                            <th class="p-3 text-right">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800/60">
                        @foreach($recentBookings as $b)
                        <tr>
                            <td class="p-3 font-bold text-[#D97706]">{{ $b->invoice_number }}</td>
                            <td class="p-3 font-semibold text-white">{{ $b->vehicle->name }}</td>
                            <td class="p-3">{{ $b->start_date->format('d/m/Y H:i') }}</td>
                            <td class="p-3">{{ $b->end_date->format('d/m/Y H:i') }}</td>
                            <td class="p-3 font-bold text-white">Rp {{ number_format($b->total_price, 0, ',', '.') }}</td>
                            <td class="p-3"><x-badges.status-badge :status="$b->status" /></td>
                            <td class="p-3 text-right">
                                <a href="{{ route('customer.bookings.show', $b->id) }}" class="px-3 py-1 bg-gray-800 hover:bg-gray-700 text-white rounded-lg text-[10px] font-bold">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-xs text-gray-500 py-4 text-center">Belum ada transaksi booking. Silakan sewa armada sekarang.</p>
        @endif
    </div>

</div>
@endsection