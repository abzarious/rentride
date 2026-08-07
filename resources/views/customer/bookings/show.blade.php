@extends('layouts.customer')

@section('title', 'Detail & Status Booking - ' . $booking->invoice_number)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('customer.bookings.index') }}" class="text-xs text-[#D97706] font-bold hover:underline">
            <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Booking Saya
        </a>
        <a href="{{ route('customer.bookings.download-pdf', $booking->id) }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl text-xs transition flex items-center gap-1.5">
            <i class="fa-solid fa-file-pdf"></i> Unduh Invoice PDF
        </a>
    </div>

    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-xl">
        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-6">Status Perjalanan Transaksi</h3>
        
        @php
            $currentStatus = strtolower($booking->status);
            $steps = [
                'pending'   => 'Menunggu Verifikasi WA',
                'approved'  => 'Disetujui Admin',
                'ongoing'   => 'Armada Dirental',
                'completed' => 'Selesai',
            ];
            $isCancelled = in_array($currentStatus, ['rejected', 'cancelled']);
        @endphp

        @if($isCancelled)
            <div class="p-4 bg-red-950/40 border border-red-800/60 rounded-xl text-red-400 text-xs flex items-center gap-2">
                <i class="fa-solid fa-circle-xmark text-lg"></i>
                <span>Transaksi ini telah <strong>{{ strtoupper($currentStatus) }}</strong>. Silakan hubungi admin via WhatsApp untuk info lebih lanjut.</span>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-center text-xs">
                @foreach($steps as $key => $label)
                    @php
                        $stepKeys = array_keys($steps);
                        $currentIndex = array_search($currentStatus, $stepKeys);
                        $thisIndex = array_search($key, $stepKeys);
                        $isPassed = $currentIndex !== false && $currentIndex >= $thisIndex;
                    @endphp
                    <div class="bg-[#030712] border p-3 rounded-xl flex flex-col items-center justify-center space-y-1.5 {{ $isPassed ? 'border-[#D97706] text-white' : 'border-gray-800 text-gray-600' }}">
                        <div class="w-7 h-7 rounded-full font-bold flex items-center justify-center text-xs {{ $isPassed ? 'bg-[#D97706] text-slate-950' : 'bg-gray-800 text-gray-500' }}">
                            {{ $thisIndex + 1 }}
                        </div>
                        <span class="font-bold text-[10px] uppercase">{{ $label }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-8 shadow-2xl space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-6 border-b border-gray-800">
            <div>
                <span class="text-xs font-extrabold text-[#D97706] uppercase tracking-widest block">INVOICE TRANSACTION</span>
                <h1 class="text-2xl font-black text-white mt-0.5">{{ $booking->invoice_number }}</h1>
                <p class="text-xs text-gray-400 mt-0.5">Tanggal Dibuat: {{ $booking->created_at->format('d M Y H:i') }} WIB</p>
            </div>
            <x-badges.status-badge :status="$booking->status" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs text-gray-300">
            <div class="bg-[#030712] border border-gray-800 p-4 rounded-xl space-y-2">
                <h4 class="font-bold text-gray-400 uppercase mb-1">Detail Kendaraan</h4>
                <p class="text-sm font-bold text-white">{{ $booking->vehicle->name }}</p>
                <p>Plat Nomor: <span class="text-[#D97706] font-bold">{{ $booking->vehicle->plate_number }}</span></p>
                <p>Kategori: {{ $booking->vehicle->brand->name ?? '' }} &bull; {{ $booking->vehicle->category->name ?? '' }}</p>
            </div>

            <div class="bg-[#030712] border border-gray-800 p-4 rounded-xl space-y-2">
                <h4 class="font-bold text-gray-400 uppercase mb-1">Periode & Total</h4>
                <p>Mulai: <span class="text-white font-semibold">{{ $booking->start_date->format('d M Y H:i') }}</span></p>
                <p>Selesai: <span class="text-white font-semibold">{{ $booking->end_date->format('d/m/Y H:i') }}</span></p>
                <p>Total Tagihan: <span class="text-base font-black text-[#D97706]">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span></p>
            </div>
        </div>

        @if(isset($whatsappUrl))
            <div class="pt-4">
                <a href="{{ $whatsappUrl }}" target="_blank" class="w-full py-3.5 bg-[#059669] hover:bg-emerald-500 text-white font-black rounded-xl transition text-center text-xs flex items-center justify-center gap-2 shadow-lg shadow-emerald-950">
                    <i class="fa-brands fa-whatsapp text-lg"></i> Hubungi WhatsApp Admin Rental
                </a>
            </div>
        @endif
    </div>

</div>
@endsection