@extends('layouts.admin')

@section('title', 'Detail Booking - ' . $booking->invoice_number)
@section('page_title', 'Detail & Pengembalian Kendaraan')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.bookings.index') }}" class="text-xs text-amber-600 font-bold hover:underline flex items-center gap-1">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Data Booking
        </a>
        <div class="flex items-center gap-2">
            <x-badges.status-badge :status="$booking->status" />
        </div>
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
                <div class="border-b border-slate-200 pb-3 flex justify-between items-start">
                    <div>
                        <span class="text-[10px] text-slate-400 font-bold uppercase block">Nomor Invoice</span>
                        <h2 class="text-2xl font-black text-slate-900">{{ $booking->invoice_number }}</h2>
                    </div>
                    <x-badges.status-badge :status="$booking->status" />
                </div>

                <div class="grid grid-cols-2 gap-4 text-xs">
                    <div>
                        <p class="text-slate-400">Customer</p>
                        <p class="font-bold text-slate-800 mt-0.5">{{ $booking->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400">WhatsApp / Telp</p>
                        <p class="font-bold text-slate-800 mt-0.5">{{ $booking->user->phone ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400">Kendaraan Dipesan</p>
                        <p class="font-bold text-slate-800 mt-0.5">{{ $booking->vehicle->name }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400">Plat Nomor & Status Unit</p>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="font-mono font-bold text-slate-800 bg-slate-100 px-2 py-0.5 rounded border">{{ $booking->vehicle->plate_number }}</span>
                            <x-badges.status-badge :status="$booking->vehicle->status" />
                        </div>
                    </div>
                    <div>
                        <p class="text-slate-400">Mulai Sewa</p>
                        <p class="font-bold text-slate-800 mt-0.5">{{ $booking->start_date->format('d/m/Y H:i') }} WIB</p>
                    </div>
                    <div>
                        <p class="text-slate-400">Batas Akhir Jadwal</p>
                        <p class="font-bold text-slate-800 mt-0.5">{{ $booking->end_date->format('d/m/Y H:i') }} WIB</p>
                    </div>
                    <div>
                        <p class="text-slate-400">Durasi Sewa</p>
                        <p class="font-bold text-slate-800 mt-0.5">{{ $booking->duration_days }} Hari</p>
                    </div>
                    <div>
                        <p class="text-slate-400">Total Tagihan</p>
                        <p class="text-base font-black text-amber-600 mt-0.5">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 space-y-2">
                    @if($booking->checked_out_at)
                        <div class="p-3 bg-blue-50 border border-blue-200 rounded-xl text-xs flex items-center justify-between">
                            <div>
                                <p class="font-bold text-blue-900"><i class="fa-solid fa-key mr-1"></i> Waktu Check-Out (Serah Terima)</p>
                                <p class="text-blue-700 text-[11px] mt-0.5">{{ $booking->checked_out_at->format('d M Y, H:i:s') }} WIB</p>
                            </div>
                            <span class="text-[10px] bg-blue-100 text-blue-800 px-2 py-0.5 rounded font-bold">Admin: {{ $booking->checkedOutBy->name ?? 'Admin' }}</span>
                        </div>
                    @endif

                    @if($booking->checked_in_at)
                        <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-xs flex items-center justify-between">
                            <div>
                                <p class="font-bold text-emerald-900"><i class="fa-solid fa-circle-check mr-1"></i> Waktu Check-In (Pengembalian Aktual)</p>
                                <p class="text-emerald-700 text-[11px] mt-0.5">{{ $booking->checked_in_at->format('d M Y, H:i:s') }} WIB</p>
                            </div>
                            <span class="text-[10px] bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded font-bold">Penerima: {{ $booking->checkedInBy->name ?? 'Admin' }}</span>
                        </div>
                    @endif
                </div>
            </div>

            @if($booking->status === 'ongoing' && !$booking->checked_in_at)
                <div class="bg-white p-6 rounded-2xl border border-blue-300 shadow-md space-y-4">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-right-to-bracket text-blue-600"></i> Form Konfirmasi Pengembalian (Check-In)
                    </h3>
                    <p class="text-xs text-slate-500">
                        Tekan tombol di bawah ini saat customer menyerahkan kembali unit kendaraan & kunci di garasi. Status kendaraan akan otomatis menjadi <strong class="text-emerald-600">Available</strong>.
                    </p>

                    <form action="{{ route('admin.bookings.process-return', $booking->id) }}" method="POST" onsubmit="return confirm('Konfirmasi pengembalian unit kendaraan ini ke garasi?');" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Catatan Pengembalian / Kondisi Unit (Opsional)</label>
                            <textarea name="notes" rows="2" placeholder="Contoh: Bensin kembali 100%, bodi mulus tidak ada lecet baru, kunci dan STNK lengkap..." class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:outline-none focus:border-blue-500"></textarea>
                        </div>
                        <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs rounded-xl transition flex items-center justify-center gap-2 shadow-lg shadow-blue-600/20">
                            <i class="fa-solid fa-right-to-bracket"></i> Konfirmasi Pengembalian & Kembalikan Unit ke Available
                        </button>
                    </form>
                </div>
            @endif

            @if($booking->status === 'approved')
                <div class="bg-white p-6 rounded-2xl border border-amber-300 shadow-md space-y-4">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-key text-amber-500"></i> Form Konfirmasi Serah Terima (Check-Out)
                    </h3>
                    <form action="{{ route('admin.bookings.process-checkout', $booking->id) }}" method="POST" onsubmit="return confirm('Serahkan kendaraan kepada customer?');" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Catatan Serah Terima (Opsional)</label>
                            <textarea name="notes" rows="2" placeholder="Contoh: Kondisi bensin full, kelengkapan helm 2 unit..." class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:outline-none focus:border-amber-500"></textarea>
                        </div>
                        <button type="submit" class="w-full py-3 bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold text-xs rounded-xl transition flex items-center justify-center gap-2 shadow-lg shadow-amber-500/20">
                            <i class="fa-solid fa-key"></i> Konfirmasi Check-Out
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-amber-500"></i> Riwayat Log Status Transaksi
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