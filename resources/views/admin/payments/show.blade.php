@extends('layouts.admin')

@section('title', 'Detail Verifikasi - ' . $booking->invoice_number)
@section('page_title', 'Detail Verifikasi Pembayaran & Approval')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.payments.index') }}" class="text-xs text-amber-600 font-bold hover:underline flex items-center gap-1">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pembayaran
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-semibold flex items-center justify-between">
            <span><i class="fa-solid fa-circle-check text-emerald-500 mr-2"></i> {{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-emerald-500"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-xs font-semibold flex items-center justify-between">
            <span><i class="fa-solid fa-triangle-exclamation text-red-500 mr-2"></i> {{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="text-red-500"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <div class="lg:col-span-7 space-y-6">
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
                        <p class="text-slate-400">Plat Nomor & Status Unit</p>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="font-bold text-slate-800">{{ $booking->vehicle->plate_number }}</span>
                            <x-badges.status-badge :status="$booking->vehicle->status" />
                        </div>
                    </div>
                    <div>
                        <p class="text-slate-400">Periode Rental</p>
                        <p class="font-bold text-slate-800 mt-0.5">{{ $booking->start_date->format('d/m/Y H:i') }} WIB</p>
                        <p class="font-bold text-slate-800">s/d {{ $booking->end_date->format('d/m/Y H:i') }} WIB</p>
                    </div>
                    <div>
                        <p class="text-slate-400">Total Tagihan</p>
                        <p class="text-base font-black text-amber-600 mt-0.5">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-amber-500"></i> Aksi Verifikasi & Approval Admin
                </h3>
                
                @if($booking->status === 'approved')
                    <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-xs font-medium">
                        <i class="fa-solid fa-circle-check text-emerald-600 mr-1"></i> Transaksi ini sudah <strong>DISETUJUI (APPROVED)</strong>. Kendaraan saat ini bertanda <strong>BOOKED</strong>.
                    </div>
                @endif

                <form action="{{ route('admin.payments.verify', $booking->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-2">Catatan Verifikasi (Opsional)</label>
                        <textarea name="notes" rows="2" placeholder="Contoh: Bukti transfer terverifikasi masuk ke rekening BCA..." class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-amber-500"></textarea>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <button type="submit" name="status" value="approved" 
                                {{ $booking->status === 'approved' ? 'disabled' : '' }}
                                class="py-2.5 bg-emerald-600 hover:bg-emerald-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold text-xs rounded-xl transition flex items-center justify-center gap-1">
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

        <div class="lg:col-span-5 space-y-6">

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-file-image text-blue-500"></i> Bukti Transfer Customer
                </h3>

                @if($booking->payment_proof)
                    <div class="group relative rounded-xl border border-slate-200 overflow-hidden bg-slate-100 flex items-center justify-center">
                        <img src="{{ asset('storage/' . $booking->payment_proof) }}" alt="Bukti Transfer" class="w-full h-56 object-cover group-hover:scale-105 transition duration-300">
                        <a href="{{ asset('storage/' . $booking->payment_proof) }}" target="_blank" class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-xs font-bold gap-2">
                            <i class="fa-solid fa-magnifying-glass-plus text-base"></i> Lihat Ukuran Penuh
                        </a>
                    </div>
                @else
                    <div class="p-6 border-2 border-dashed border-slate-200 rounded-xl text-center space-y-2">
                        <i class="fa-solid fa-receipt text-2xl text-slate-300"></i>
                        <p class="text-xs text-slate-400">Customer belum mengunggah bukti transfer.</p>
                    </div>
                @endif
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-amber-500"></i> Riwayat Log Status
                </h3>

                @if($booking->statusLogs && $booking->statusLogs->count() > 0)
                    <div class="space-y-3 relative before:absolute before:inset-0 before:left-3.5 before:w-0.5 before:bg-slate-200 text-xs">
                        @foreach($booking->statusLogs as $log)
                            <div class="flex items-start gap-3 relative z-10 pl-1">
                                <div class="w-6 h-6 rounded-full bg-amber-500 text-slate-950 font-extrabold flex items-center justify-center text-[10px] shrink-0">
                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                </div>
                                <div class="bg-slate-50 border border-slate-200 p-3 rounded-xl flex-1 space-y-1">
                                    <div class="flex justify-between items-center">
                                        <span class="font-bold text-slate-800 uppercase">{{ $log->to_status }}</span>
                                        <span class="text-[10px] text-slate-400">{{ $log->created_at->format('d/m H:i') }}</span>
                                    </div>
                                    <p class="text-[11px] text-slate-600">{{ $log->notes ?? '-' }}</p>
                                    <p class="text-[10px] text-amber-600 font-semibold">Oleh: {{ $log->user->name ?? 'Admin' }}</p>
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