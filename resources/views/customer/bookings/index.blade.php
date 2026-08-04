@extends('layouts.customer')

@section('title', 'Booking Saya - RentRide')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Booking Saya (Aktif)</h1>
            <p class="text-xs text-gray-400">Daftar transaksi penyewaan yang sedang berjalan atau menunggu verifikasi.</p>
        </div>
    </div>

    @if($bookings->count() > 0)
        <div class="space-y-4">
            @foreach($bookings as $booking)
                <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gray-900 rounded-xl overflow-hidden shrink-0 border border-gray-800 flex items-center justify-center">
                            @if($booking->vehicle->thumbnail)
                                <img src="{{ asset('storage/' . $booking->vehicle->thumbnail) }}" class="w-full h-full object-cover">
                            @else
                                <i class="fa-solid fa-car text-gray-600 text-2xl"></i>
                            @endif
                        </div>
                        <div>
                            <span class="text-xs font-bold text-[#D97706] mr-2">{{ $booking->invoice_number }}</span>
                            <x-badges.status-badge :status="$booking->status" />
                            <h3 class="text-base font-bold text-white mt-1">{{ $booking->vehicle->name }}</h3>
                            <p class="text-xs text-gray-400 mt-0.5">
                                <i class="fa-regular fa-calendar mr-1"></i> {{ $booking->start_date->format('d M Y H:i') }} - {{ $booking->end_date->format('d M Y H:i') }} ({{ $booking->duration_days }} Hari)
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 w-full md:w-auto justify-between md:justify-end border-t md:border-0 border-gray-800 pt-4 md:pt-0">
                        <div class="text-left md:text-right">
                            <span class="text-[10px] text-gray-400 block uppercase">Total Biaya</span>
                            <span class="text-lg font-black text-white">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>
                        <a href="#" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white text-xs font-semibold rounded-xl border border-gray-700 transition">
                            Detail Invoice
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">
            {{ $bookings->links() }}
        </div>
    @else
        <x-empty.empty-data title="Tidak Ada Booking Aktif" description="Anda tidak memiliki transaksi penyewaan yang sedang berjalan saat ini.">
            <a href="/" class="inline-block px-5 py-2.5 bg-[#D97706] text-slate-950 font-bold text-xs rounded-xl hover:bg-amber-500 transition mt-3">
                Cari & Sewa Armada Sekarang
            </a>
        </x-empty.empty-data>
    @endif

</div>
@endsection