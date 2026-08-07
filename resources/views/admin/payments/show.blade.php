@extends('layouts.admin')

@section('title', 'Detail Verifikasi - ' . $booking->invoice_number)
@section('page_title', 'Detail Verifikasi Pembayaran')

@section('content')
<div class="max-w-5xl space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.payments.index') }}" class="text-xs text-amber-600 font-bold hover:underline">
            <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Daftar Pembayaran
        </a>
    </div>

    @if(session('success'))
        <x-alerts.alert type="success">{{ session('success') }}</x-alerts.alert>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

        <div class="md:col-span-7 space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <div class="flex justify-between items-start border-b border-slate-200 pb-3">
                    <div>
                        <span class="text-[10px] text-slate-400 font-bold uppercase block">Nomor Invoice</span>
                        <h2 class="text-xl font-bold text-slate-900">{{ $booking->invoice_number }}</h2>
                    </div>
                    <x-badges.status-badge :status="$booking->status" />
                </div>

                <div class="grid grid-cols-2 gap-4 text-xs">
                    <div>
                        <p class="text-slate-400">Nama Customer</p>
                        <p class="font-bold text-slate-800 mt-0.5">{{ $booking->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400">WhatsApp / Telp</p>
                        <p class="font-bold text-slate-800 mt-0.5">{{ $booking->user->phone ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400">Armada Dipesan</p>
                        <p class="font-bold text-slate-800 mt-0.5">{{ $booking->vehicle->name }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400">Plat Nomor</p>
                        <p class="font-bold text-slate-800 mt-0.5">{{ $booking->vehicle->plate_number }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400">Periode Rental</p>
                        <p class="font-bold text-slate-800 mt-0.5">{{ $booking->start_date->format('d/m/Y H:i') }} WIB</p>
                        <p class="font-bold text-slate-800">s/d {{ $booking->end_date->format('d/m/Y H:i') }} WIB</p>
                    </div>
                    <div>
                        <p class="text-slate-400">Total Biaya Tagihan</p>
                        <p class="text-base font-black text-amber-600 mt-0.5">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Aksi Verifikasi Admin</h3>
                
                <form action="{{ route('admin.payments.verify', $booking->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-2">Catatan Verifikasi (Opsional)</label>
                        <textarea name="notes" rows="2" placeholder="Contoh: Bukti transfer valid / Pembayaran belum masuk ke rekening..." class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-amber-500"></textarea>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <button type="submit" name="status" value="approved" class="py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl transition flex items-center justify-center gap-1">
                            <i class="fa-solid fa-check"></i> Setujui (Approve)
                        </button>
                        <button type="submit" name="status" value="rejected" class="py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold text-xs rounded-xl transition flex items-center justify-center gap-1">
                            <i class="fa-solid fa-xmark"></i> Tolak (Reject)
                        </button>
                        <button type="submit" name="status" value="pending" class="py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs rounded-xl transition flex items-center justify-center gap-1">
                            <i class="fa-solid fa-rotate-left"></i> Set Pending
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="md:col-span-5 space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Riwayat Log Status Booking</h3>

                @if($booking->statusLogs->count() > 0)
                    <div class="space-y-3 relative before:absolute before:inset-0 before:left-3.5 before:w-0.5 before:bg-slate-200 text-xs">
                        @foreach($booking->statusLogs as $log)
                            <div class="flex items-start gap-3 relative z-10 pl-1">
                                <div class="w-6 h-6 rounded-full bg-amber-500 text-slate-950 font-extrabold flex items-center justify-center text-[10px] shrink-0">
                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                </div>
                                <div class="bg-slate-50 border border-slate-200 p-3 rounded-xl flex-1 space-y-1">
                                    <div class="flex justify-between items-center">
                                        <span class="font-bold text-slate-800 uppercase">{{ $log->to_status }}</span>
                                        <span class="text-[10px] text-slate-400">{{ $log->created_at->format('d/m/H:i') }}</span>
                                    </div>
                                    <p class="text-[11px] text-slate-600">{{ $log->notes ?? '-' }}</p>
                                    <p class="text-[10px] text-amber-600 font-semibold">Oleh: {{ $log->user->name ?? 'Sistem/Admin' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-slate-400 italic">Belum ada riwayat perubahan status.</p>
                @endif
            </div>
        </div>

    </div>

</div>
@endsection