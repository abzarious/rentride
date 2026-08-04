@extends('layouts.customer')

@section('title', 'Invoice ' . $booking->invoice_number)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    @if(session('success'))
        <x-alerts.alert type="success" class="mb-6">
            {{ session('success') }}
        </x-alerts.alert>
    @endif

    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-8 shadow-2xl relative overflow-hidden">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pb-6 border-b border-gray-800">
            <div>
                <span class="text-xs font-extrabold text-[#D97706] uppercase tracking-widest">INVOICE PEMESANAN</span>
                <h1 class="text-3xl font-black text-white mt-1">{{ $booking->invoice_number }}</h1>
                <p class="text-xs text-gray-400 mt-1">Dibuat pada: {{ $booking->created_at->format('d M Y H:i') }} WIB</p>
            </div>
            <div>
                <x-badges.status-badge :status="$booking->status" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 py-6 border-b border-gray-800 text-xs">
            <div>
                <h4 class="font-bold text-gray-400 uppercase mb-2">Penyewa (Customer)</h4>
                <p class="text-sm font-bold text-white">{{ $booking->user->name }}</p>
                <p class="text-gray-400 mt-1"><i class="fa-regular fa-envelope mr-1"></i> {{ $booking->user->email }}</p>
                <p class="text-gray-400 mt-1"><i class="fa-brands fa-whatsapp text-[#059669] mr-1"></i> {{ $booking->user->phone ?? '-' }}</p>
            </div>
            <div>
                <h4 class="font-bold text-gray-400 uppercase mb-2">Penyedia Layanan</h4>
                <p class="text-sm font-bold text-white">{{ $setting->company_name ?? 'RentRide' }}</p>
                <p class="text-gray-400 mt-1"><i class="fa-solid fa-location-dot mr-1"></i> {{ $setting->address ?? 'Malang, Jawa Timur' }}</p>
                <p class="text-gray-400 mt-1"><i class="fa-brands fa-whatsapp text-[#059669] mr-1"></i> +{{ $setting->whatsapp ?? '6281234567890' }}</p>
            </div>
        </div>

        <div class="py-6 border-b border-gray-800">
            <h4 class="text-xs font-bold text-gray-400 uppercase mb-4">Rincian Sewa Armada</h4>
            <div class="bg-[#030712] border border-gray-800 p-4 rounded-xl flex items-center gap-4">
                <div class="w-16 h-16 bg-gray-900 rounded-lg overflow-hidden shrink-0">
                    @if($booking->vehicle->thumbnail)
                        <img src="{{ asset('storage/' . $booking->vehicle->thumbnail) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-600"><i class="fa-solid fa-car"></i></div>
                    @endif
                </div>
                <div class="flex-1">
                    <h3 class="text-base font-bold text-white">{{ $booking->vehicle->name }}</h3>
                    <p class="text-xs text-gray-400">{{ $booking->vehicle->brand->name }} &bull; Plat: {{ $booking->vehicle->plate_number }}</p>
                </div>
                <div class="text-right text-xs">
                    <p class="text-gray-400">Durasi</p>
                    <p class="font-bold text-white text-sm">{{ $booking->duration_days }} Hari</p>
                </div>
            </div>
        </div>

        <div class="py-6 border-b border-gray-800 space-y-2 text-xs">
            <div class="flex justify-between text-gray-400">
                <span>Tanggal Mulai</span>
                <span class="font-semibold text-white">{{ $booking->start_date->format('d M Y H:i') }} WIB</span>
            </div>
            <div class="flex justify-between text-gray-400">
                <span>Tanggal Selesai</span>
                <span class="font-semibold text-white">{{ $booking->end_date->format('d M Y H:i') }} WIB</span>
            </div>
            <div class="flex justify-between text-gray-400">
                <span>Tarif Per Hari</span>
                <span class="font-semibold text-white">Rp {{ number_format($booking->price_per_day, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm font-extrabold text-white pt-2 border-t border-gray-800">
                <span>Total Pembayaran</span>
                <span class="text-xl text-[#D97706]">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="py-6 border-b border-gray-800">
            <h4 class="text-xs font-bold text-gray-400 uppercase mb-2">Instruksi Transfer Bank Manual</h4>
            <div class="bg-[#030712] p-4 rounded-xl border border-gray-800 text-xs">
                <p class="text-white font-bold">{{ $setting->bank_name ?? 'BCA' }}: <span class="text-[#D97706] font-mono text-sm">{{ $setting->bank_number ?? '1234567890' }}</span></p>
                <p class="text-gray-400">a.n. {{ $setting->bank_holder ?? 'PT RentRide' }}</p>
            </div>
        </div>

        @php
            $waAdmin = $setting->whatsapp ?? '6281234567890';
            $message = "Halo Admin " . ($setting->company_name ?? 'RentRide') . ".\n\nSaya sudah membuat booking dengan rincian:\n- Invoice: *" . $booking->invoice_number . "*\n- Nama: *" . $booking->user->name . "*\n- Armada: *" . $booking->vehicle->name . "*\n- Total: *Rp " . number_format($booking->total_price, 0, ',', '.') . "*\n\nMohon petunjuk untuk verifikasi pembayaran. Terima kasih!";
            $waUrl = "https://wa.me/" . preg_replace('/[^0-9]/', '', $waAdmin) . "?text=" . urlencode($message);
        @endphp

        <div class="pt-6 flex flex-col sm:flex-row gap-4">
            <a href="{{ $waUrl }}" target="_blank" class="flex-1 py-3 bg-[#059669] hover:bg-emerald-500 text-white font-extrabold rounded-xl transition text-center text-xs flex items-center justify-center gap-2 shadow-lg shadow-emerald-950">
                <i class="fa-brands fa-whatsapp text-lg"></i> Konfirmasi via WhatsApp
            </a>
            <a href="{{ route('customer.bookings.index') }}" class="px-6 py-3 bg-gray-800 hover:bg-gray-700 text-gray-300 font-bold rounded-xl text-center text-xs transition">
                Kembali ke Booking Saya
            </a>
        </div>

    </div>
</div>
@endsection