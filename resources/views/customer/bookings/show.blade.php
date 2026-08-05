@extends('layouts.customer')

@section('title', 'Detail Booking ' . $booking->invoice_number)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('customer.bookings.index') }}" class="text-xs text-[#D97706] font-bold hover:underline">
            <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Daftar Booking
        </a>
        <a href="{{ route('customer.bookings.download-pdf', $booking->id) }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl text-xs transition flex items-center gap-1.5">
            <i class="fa-solid fa-file-pdf"></i> Cetak PDF
        </a>
    </div>

    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-xl">
        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-6">Progres Perjalanan Transaksi</h3>
        
        @php
            $statuses = ['pending', 'approved', 'ongoing', 'completed'];
            $currentStatus = strtolower($booking->status);
            $isCancelled = in_array($currentStatus, ['rejected', 'cancelled']);
        @endphp

        @if($isCancelled)
            <div class="p-4 bg-red-950/40 border border-red-800/60 rounded-xl text-red-400 text-xs flex items-center gap-2">
                <i class="fa-solid fa-circle-xmark text-lg"></i>
                <span>Transaksi ini telah <strong>{{ strtoupper($currentStatus) }}</strong>. Silakan ajukan pemesanan baru.</span>
            </div>
        @else
            <div class="grid grid-cols-4 gap-2 text-center text-[11px]">
                @foreach($statuses as $index => $st)
                    @php
                        $isPassed = array_search($currentStatus, $statuses) >= $index;
                    @endphp
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold mb-2 transition {{ $isPassed ? 'bg-[#D97706] text-slate-950' : 'bg-gray-800 text-gray-500' }}">
                            {{ $index + 1 }}
                        </div>
                        <span class="{{ $isPassed ? 'text-white font-bold' : 'text-gray-500' }} uppercase text-[10px]">{{ $st }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-8 shadow-2xl">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-6 border-b border-gray-800">
            <div>
                <span class="text-xs font-extrabold text-[#D97706] uppercase tracking-widest block">DETAIL INVOICE</span>
                <h1 class="text-2xl font-black text-white mt-0.5">{{ $booking->invoice_number }}</h1>
                <p class="text-xs text-gray-400 mt-0.5">Dibuat pada: {{ $booking->created_at->format('d M Y H:i') }} WIB</p>
            </div>
            <x-badges.status-badge :status="$booking->status" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 py-6 border-b border-gray-800 text-xs">
            <div class="space-y-1.5">
                <h4 class="font-bold text-gray-400 uppercase mb-2">Informasi Penyewa</h4>
                <p class="text-sm font-bold text-white">{{ $booking->user->name }}</p>
                <p class="text-gray-400"><i class="fa-regular fa-envelope mr-1.5"></i> {{ $booking->user->email }}</p>
                <p class="text-gray-400"><i class="fa-brands fa-whatsapp text-emerald-500 mr-1.5"></i> {{ $booking->user->phone ?? '-' }}</p>
            </div>

            <div class="space-y-1.5">
                <h4 class="font-bold text-gray-400 uppercase mb-2">Informasi Kendaraan</h4>
                <p class="text-sm font-bold text-white">{{ $booking->vehicle->name }}</p>
                <p class="text-gray-400">Merk/Kategori: {{ $booking->vehicle->brand->name ?? '-' }} &bull; {{ $booking->vehicle->category->name ?? '-' }}</p>
                <p class="text-gray-400"><i class="fa-solid fa-barcode mr-1.5"></i> Plat: {{ $booking->vehicle->plate_number }}</p>
            </div>
        </div>

        <div class="py-6 space-y-2 text-xs border-b border-gray-800">
            <div class="flex justify-between text-gray-400">
                <span>Tanggal & Waktu Mulai</span>
                <span class="font-semibold text-white">{{ $booking->start_date->format('d M Y H:i') }} WIB</span>
            </div>
            <div class="flex justify-between text-gray-400">
                <span>Tanggal & Waktu Selesai</span>
                <span class="font-semibold text-white">{{ $booking->end_date->format('d M Y H:i') }} WIB</span>
            </div>
            <div class="flex justify-between text-gray-400">
                <span>Durasi Rental</span>
                <span class="font-bold text-white">{{ $booking->duration_days }} Hari</span>
            </div>
            <div class="flex justify-between text-gray-400">
                <span>Biaya Admin Layanan</span>
                <span class="font-bold text-emerald-400">+ Rp {{ number_format($booking->admin_fee ?? 5000, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm font-extrabold text-white pt-3 border-t border-gray-800">
                <span>Total Pembayaran</span>
                <span class="text-xl text-[#D97706]">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="pt-6">
            <a href="{{ $whatsappUrl }}" target="_blank" class="w-full py-3.5 bg-[#059669] hover:bg-emerald-500 text-white font-extrabold rounded-xl transition text-center text-xs flex items-center justify-center gap-2 shadow-lg shadow-emerald-950">
                <i class="fa-brands fa-whatsapp text-lg"></i> Konfirmasi Pesanan ke Admin via WhatsApp
            </a>
        </div>
    </div>

</div>
@endsection