@extends('layouts.customer')

@section('title', 'Detail Booking ' . $booking->invoice_number)

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">

    <div class="flex items-center justify-between">
        <a href="{{ route('customer.bookings.index') }}" class="text-xs font-bold text-[#D97706] hover:underline flex items-center gap-1">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Booking Saya
        </a>
        <x-badges.status-badge :status="$booking->status" />
    </div>

    @php
        $step = match($booking->status) {
            'pending'   => 1,
            'approved'  => 2,
            'ongoing'   => 3,
            'completed' => 4,
            default     => 0,
        };
    @endphp

    <div class="bg-[#111827] border border-gray-800 p-6 rounded-2xl shadow-xl">
        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6">Timeline Status Rental</h3>
        
        <div class="grid grid-cols-4 gap-2 text-center text-xs relative before:absolute before:top-4 before:left-0 before:w-full before:h-1 before:bg-gray-800 z-0">
            
            <div class="relative z-10 flex flex-col items-center">
                <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-xs {{ $step >= 1 ? 'bg-[#D97706] text-slate-950 shadow-lg shadow-amber-600/30' : 'bg-gray-800 text-gray-500' }}">
                    1
                </div>
                <span class="mt-2 font-semibold {{ $step >= 1 ? 'text-white' : 'text-gray-500' }}">Booking Dibuat</span>
                <span class="text-[10px] text-gray-500 mt-0.5">Pending Verifikasi</span>
            </div>

            <div class="relative z-10 flex flex-col items-center">
                <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-xs {{ $step >= 2 ? 'bg-[#D97706] text-slate-950 shadow-lg shadow-amber-600/30' : 'bg-gray-800 text-gray-500' }}">
                    2
                </div>
                <span class="mt-2 font-semibold {{ $step >= 2 ? 'text-white' : 'text-gray-500' }}">Pembayaran Valid</span>
                <span class="text-[10px] text-gray-500 mt-0.5">Siap Diambil</span>
            </div>

            <div class="relative z-10 flex flex-col items-center">
                <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-xs {{ $step >= 3 ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'bg-gray-800 text-gray-500' }}">
                    3
                </div>
                <span class="mt-2 font-semibold {{ $step >= 3 ? 'text-white' : 'text-gray-500' }}">Serah Terima Unit</span>
                <span class="text-[10px] text-gray-500 mt-0.5">Sedang Disewa</span>
            </div>

            <div class="relative z-10 flex flex-col items-center">
                <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-xs {{ $step >= 4 ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/30' : 'bg-gray-800 text-gray-500' }}">
                    4
                </div>
                <span class="mt-2 font-semibold {{ $step >= 4 ? 'text-white' : 'text-gray-500' }}">Pengembalian Unit</span>
                <span class="text-[10px] text-gray-500 mt-0.5">Selesai (Returned)</span>
            </div>

        </div>
    </div>

    <div class="bg-[#111827] border border-gray-800 p-6 rounded-2xl shadow-xl space-y-4">
        <div class="border-b border-gray-800 pb-3 flex justify-between items-center">
            <div>
                <span class="text-[10px] text-gray-400 font-bold uppercase">Invoice</span>
                <h2 class="text-2xl font-black text-[#D97706]">{{ $booking->invoice_number }}</h2>
            </div>
            <a href="{{ route('customer.bookings.download-pdf', $booking->id) }}" class="px-3 py-1.5 bg-gray-800 hover:bg-gray-700 text-white text-xs font-bold rounded-lg transition flex items-center gap-1.5">
                <i class="fa-solid fa-file-pdf text-red-400"></i> Download Invoice
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs text-gray-300">
            <div>
                <p class="text-gray-500">Kendaraan Dipesan</p>
                <p class="font-bold text-white text-sm mt-0.5">{{ $booking->vehicle->name }}</p>
                <p class="text-gray-400 text-[10px]">{{ $booking->vehicle->plate_number }}</p>
            </div>
            <div>
                <p class="text-gray-500">Total Biaya Tagihan</p>
                <p class="font-extrabold text-[#D97706] text-sm mt-0.5">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-gray-500">Waktu Mulai Sewa</p>
                <p class="font-bold text-white mt-0.5">{{ $booking->start_date->format('d/m/Y H:i') }} WIB</p>
            </div>
            <div>
                <p class="text-gray-500">Batas Waktu Pengembalian</p>
                <p class="font-bold text-white mt-0.5">{{ $booking->end_date->format('d/m/Y H:i') }} WIB</p>
            </div>
            <div>
                <p class="text-gray-500">Waktu Serah Terima (Check-Out)</p>
                <p class="font-bold text-blue-400 mt-0.5">
                    {{ $booking->checked_out_at ? $booking->checked_out_at->format('d M Y H:i') . ' WIB' : 'Belum diserahterimakan' }}
                </p>
            </div>
            <div>
                <p class="text-gray-500">Waktu Pengembalian Aktual (Check-In)</p>
                <p class="font-bold text-emerald-400 mt-0.5">
                    {{ $booking->checked_in_at ? $booking->checked_in_at->format('d M Y H:i') . ' WIB' : 'Belum dikembalikan' }}
                </p>
            </div>
        </div>
    </div>

</div>
@endsection