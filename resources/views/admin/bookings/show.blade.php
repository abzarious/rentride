@extends('layouts.admin')

@section('title', 'Detail Booking ' . $booking->invoice_number)
@section('page_title', 'Detail Transaksi Booking')

@section('content')
<div class="max-w-4xl space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.bookings.index') }}" class="text-xs text-amber-600 font-bold hover:underline">
            <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Daftar Booking
        </a>
    </div>

    @if(session('success'))
        <x-alerts.alert type="success">{{ session('success') }}</x-alerts.alert>
    @endif
    @if(session('error'))
        <x-alerts.alert type="danger">{{ session('error') }}</x-alerts.alert>
    @endif

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase">Status Transaksi Saat Ini</span>
            <div class="mt-1"><x-badges.status-badge :status="$booking->status" /></div>
        </div>

        @if(!in_array($booking->status, ['completed', 'rejected', 'cancelled']))
            <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST" class="flex items-center gap-3">
                @csrf
                @method('PUT')
                <select name="status" required class="px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs font-bold text-slate-700 focus:outline-none focus:border-amber-500">
                    <option value="" disabled selected>Ubah Status...</option>
                    @if($booking->status === 'pending')
                        <option value="approved">Setujui (Approved)</option>
                        <option value="rejected">Tolak (Rejected)</option>
                    @elseif($booking->status === 'approved')
                        <option value="ongoing">Mulai Rental (Ongoing)</option>
                        <option value="cancelled">Batalkan (Cancelled)</option>
                    @elseif($booking->status === 'ongoing')
                        <option value="completed">Selesai Rental (Completed)</option>
                    @endif
                </select>
                <button type="submit" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-xl transition shadow-sm">
                    Simpan Perubahan
                </button>
            </form>
        @else
            <span class="text-xs text-slate-400 italic">Transaksi telah bersifat final.</span>
        @endif
    </div>

    <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6 text-xs text-slate-700">
        <div class="flex justify-between items-start border-b border-slate-200 pb-4">
            <div>
                <h2 class="text-xl font-bold text-slate-900">{{ $booking->invoice_number }}</h2>
                <p class="text-slate-400">Tanggal Transaksi: {{ $booking->created_at->format('d M Y H:i') }} WIB</p>
            </div>
            <span class="text-sm font-extrabold text-amber-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-2">
                <h4 class="font-bold text-slate-900 uppercase mb-2">Identitas Pelanggan</h4>
                <p><strong>Nama:</strong> {{ $booking->user->name }}</p>
                <p><strong>Email:</strong> {{ $booking->user->email }}</p>
                <p><strong>No. WA:</strong> {{ $booking->user->phone ?? '-' }}</p>
                <p><strong>NIK:</strong> {{ $booking->user->profile->nik ?? '-' }}</p>
            </div>

            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-2">
                <h4 class="font-bold text-slate-900 uppercase mb-2">Kendaraan Dipesan</h4>
                <p><strong>Nama Armada:</strong> {{ $booking->vehicle->name }}</p>
                <p><strong>Plat Nomor:</strong> {{ $booking->vehicle->plate_number }}</p>
                <p><strong>Durasi Rental:</strong> {{ $booking->duration_days }} Hari</p>
            </div>
        </div>
    </div>

</div>
@endsection