@extends('layouts.customer')

@section('title', 'Detail Booking ' . $booking->invoice_number)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">

    @if(session('success'))
        <x-alerts.alert type="success">
            {{ session('success') }}
        </x-alerts.alert>
    @endif

    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-xl">
        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-6">Status Perjalanan Transaksi</h3>
        
        @php
            $statuses = ['pending', 'approved', 'ongoing', 'completed'];
            $currentStatus = strtolower($booking->status);
            $isCancelled = in_array($currentStatus, ['rejected', 'cancelled']);
        @endphp

        @if($isCancelled)
            <div class="p-4 bg-red-950/40 border border-red-800/60 rounded-xl text-red-400 text-xs flex items-center gap-2">
                <i class="fa-solid fa-circle-xmark text-lg"></i>
                <span>Transaksi ini telah <strong>{{ strtoupper($currentStatus) }}</strong>. Silakan buat pemesanan baru.</span>
            </div>
        @else
            <div class="grid grid-cols-4 gap-2 text-center text-[11px]">
                @foreach($statuses as $index => $st)
                    @php
                        $isPassed = array_search($currentStatus, $statuses) >= $index;
                    @endphp
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold mb-2 {{ $isPassed ? 'bg-[#D97706] text-slate-950' : 'bg-gray-800 text-gray-500' }}">
                            {{ $index + 1 }}
                        </div>
                        <span class="{{ $isPassed ? 'text-white font-bold' : 'text-gray-500' }} uppercase">{{ $st }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-8 shadow-2xl">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-6 border-b border-gray-800">
            <div>
                <span class="text-xs font-extrabold text-[#D97706] uppercase tracking-widest">INVOICE PEMESANAN</span>
                <h1 class="text-2xl font-black text-white mt-1">{{ $booking->invoice_number }}</h1>
                <p class="text-xs text-gray-400 mt-0.5">Dibuat: {{ $booking->created_at->format('d M Y H:i') }} WIB</p>
            </div>
            <div class="flex items-center gap-2">
                <x-badges.status-badge :status="$booking->status" />
                <a href="{{ route('customer.bookings.preview-invoice', $booking->id) }}" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white font-bold rounded-xl text-xs transition border border-gray-700">
                    <i class="fa-solid fa-file-invoice mr-1"></i> Preview Invoice
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 py-6 border-b border-gray-800 text-xs">
            <div>
                <h4 class="font-bold text-gray-400 uppercase mb-2">Informasi Penyewa</h4>
                <p class="text-sm font-bold text-white">{{ $booking->user->name }}</p>
                <p class="text-gray-400 mt-1"><i class="fa-regular fa-envelope mr-1"></i> {{ $booking->user->email }}</p>
                <p class="text-gray-400 mt-1"><i class="fa-brands fa-whatsapp text-[#059669] mr-1"></i> {{ $booking->user->phone ?? '-' }}</p>
            </div>
            <div>
                <h4 class="font-bold text-gray-400 uppercase mb-2">Armada Yang Disewa</h4>
                <p class="text-sm font-bold text-white">{{ $booking->vehicle->name }}</p>
                <p class="text-gray-400 mt-1">Plat: {{ $booking->vehicle->plate_number }}</p>
                <p class="text-gray-400 mt-1">Durasi: {{ $booking->duration_days }} Hari</p>
            </div>
        </div>

        <div class="py-6 space-y-2 text-xs">
            <div class="flex justify-between text-gray-400">
                <span>Tanggal Mulai</span>
                <span class="font-semibold text-white">{{ $booking->start_date->format('d M Y H:i') }} WIB</span>
            </div>
            <div class="flex justify-between text-gray-400">
                <span>Tanggal Selesai</span>
                <span class="font-semibold text-white">{{ $booking->end_date->format('d M Y H:i') }} WIB</span>
            </div>
            <div class="flex justify-between text-sm font-extrabold text-white pt-2 border-t border-gray-800">
                <span>Total Pembayaran</span>
                <span class="text-xl text-[#D97706]">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        @php
            $waAdmin = $setting->whatsapp ?? '6281234567890';
            $message = "Halo Admin " . ($setting->company_name ?? 'RentRide') . ".\n\nSaya ingin konfirmasi booking:\n- Invoice: *" . $booking->invoice_number . "*\n- Nama: *" . $booking->user->name . "*\n- Total: *Rp " . number_format($booking->total_price, 0, ',', '.') . "*\n\nMohon verifikasi. Terima kasih!";
            $waUrl = "https://wa.me/" . preg_replace('/[^0-9]/', '', $waAdmin) . "?text=" . urlencode($message);
        @endphp

        <div class="pt-6 flex flex-col sm:flex-row gap-4">
            <a href="{{ $waUrl }}" target="_blank" class="flex-1 py-3 bg-[#059669] hover:bg-emerald-500 text-white font-extrabold rounded-xl transition text-center text-xs flex items-center justify-center gap-2">
                <i class="fa-brands fa-whatsapp text-lg"></i> Konfirmasi via WhatsApp
            </a>
            <a href="{{ route('customer.bookings.download-pdf', $booking->id) }}" class="px-5 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl text-center text-xs transition">
                <i class="fa-solid fa-file-pdf mr-1"></i> Download PDF
            </a>
        </div>

    </div>
</div>
@endsection