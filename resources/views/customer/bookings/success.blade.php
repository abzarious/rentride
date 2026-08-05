@extends('layouts.customer')

@section('title', 'Booking Berhasil - ' . $booking->invoice_number)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <div class="bg-[#111827] border border-gray-800 rounded-3xl p-8 shadow-2xl text-center relative overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-96 h-32 bg-amber-500/10 blur-3xl rounded-full pointer-events-none"></div>

        <div class="w-20 h-20 bg-emerald-950 border-2 border-emerald-500/40 text-emerald-400 rounded-full flex items-center justify-center text-3xl mx-auto mb-6 shadow-xl shadow-emerald-950/50">
            <i class="fa-solid fa-circle-check"></i>
        </div>

        <span class="text-xs font-bold text-[#D97706] uppercase tracking-widest block mb-1">Pemesanan Berhasil</span>
        <h1 class="text-3xl font-black text-white">Terima Kasih, Pemesanan Anda Diterima!</h1>
        <p class="text-xs text-gray-400 mt-2 max-w-md mx-auto leading-relaxed">
            Invoice transaksi telah berhasil diterbitkan. Silakan klik tombol di bawah ini untuk mengirimkan konfirmasi langsung ke WhatsApp Admin.
        </p>

        <div class="bg-[#030712] border border-gray-800 rounded-2xl p-6 mt-8 text-left space-y-3 text-xs">
            <div class="flex justify-between items-center pb-3 border-b border-gray-800">
                <span class="text-gray-400">Nomor Invoice</span>
                <span class="text-sm font-black text-[#D97706]">{{ $booking->invoice_number }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-400">Armada Yang Disewa</span>
                <span class="font-bold text-white">{{ $booking->vehicle->name }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-400">Periode Sewa</span>
                <span class="font-semibold text-gray-300">{{ $booking->start_date->format('d/m/Y H:i') }} - {{ $booking->end_date->format('d/m/Y H:i') }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-400">Lama Rental</span>
                <span class="font-bold text-white">{{ $booking->duration_days }} Hari</span>
            </div>
            <div class="flex justify-between items-center pt-3 border-t border-gray-800 text-sm">
                <span class="font-bold text-white">Total Tagihan</span>
                <span class="font-black text-[#D97706] text-base">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center pt-2">
                <span class="text-gray-400">Status Saat Ini</span>
                <x-badges.status-badge :status="$booking->status" />
            </div>
        </div>

        <div class="mt-8 space-y-3 sm:space-y-0 sm:flex sm:gap-3">
            <a href="{{ $whatsappUrl }}" target="_blank" class="w-full sm:flex-1 py-3.5 bg-[#059669] hover:bg-emerald-500 text-white font-black rounded-xl transition text-xs flex items-center justify-center gap-2 shadow-lg shadow-emerald-950">
                <i class="fa-brands fa-whatsapp text-lg"></i> Konfirmasi via WhatsApp
            </a>
            <a href="{{ route('customer.bookings.show', $booking->id) }}" class="w-full sm:flex-1 py-3.5 bg-gray-800 hover:bg-gray-700 text-white font-bold rounded-xl transition text-xs flex items-center justify-center gap-2 border border-gray-700">
                <i class="fa-solid fa-eye"></i> Lihat Detail Booking
            </a>
        </div>

        <div class="mt-4 flex justify-center gap-4 text-xs text-gray-500">
            <a href="{{ route('customer.bookings.download-pdf', $booking->id) }}" class="hover:text-[#D97706] transition">
                <i class="fa-solid fa-file-pdf mr-1"></i> Unduh Invoice PDF
            </a>
            <span>&bull;</span>
            <a href="{{ route('customer.dashboard') }}" class="hover:text-[#D97706] transition">
                <i class="fa-solid fa-house mr-1"></i> Kembali ke Dashboard
            </a>
        </div>

    </div>

</div>
@endsection