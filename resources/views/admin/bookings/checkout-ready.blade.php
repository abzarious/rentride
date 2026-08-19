@extends('layouts.admin')

@section('title', 'Siap Check-Out - RentRide')
@section('page_title', 'Serah Terima Kendaraan (Check-Out)')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Siap Diserahterimakan</h1>
            <p class="text-xs text-slate-500 mt-1">Daftar booking yang pembayarannya telah diverifikasi dan siap di-Check-Out oleh admin.</p>
        </div>
        <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold rounded-xl transition flex items-center gap-2">
            <i class="fa-solid fa-list"></i> Semua Data Booking
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-semibold flex items-center justify-between">
            <span><i class="fa-solid fa-circle-check text-emerald-500 mr-2"></i> {{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-emerald-500"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] border-b border-slate-200">
                    <tr>
                        <th class="p-4">INVOICE</th>
                        <th class="p-4">CUSTOMER</th>
                        <th class="p-4">KENDARAAN</th>
                        <th class="p-4">TANGGAL SEWA</th>
                        <th class="p-4">STATUS</th>
                        <th class="p-4 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($bookings as $b)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-bold text-amber-600">{{ $b->invoice_number }}</td>
                            <td class="p-4">
                                <p class="font-bold text-slate-800">{{ $b->user->name }}</p>
                                <p class="text-[10px] text-slate-400">{{ $b->user->phone ?? '-' }}</p>
                            </td>
                            <td class="p-4">
                                <p class="font-bold text-slate-800">{{ $b->vehicle->name }}</p>
                                <p class="text-[10px] text-slate-400">{{ $b->vehicle->plate_number }}</p>
                            </td>
                            <td class="p-4">
                                <p class="font-medium text-slate-800">{{ $b->start_date->format('d/m/Y H:i') }} WIB</p>
                                <p class="text-[10px] text-slate-400">Durasi: {{ $b->duration_days }} Hari</p>
                            </td>
                            <td class="p-4"><x-badges.status-badge :status="$b->status" /></td>
                            <td class="p-4 text-center">
                                <a href="{{ route('admin.bookings.show', $b->id) }}" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-slate-900 text-xs font-bold rounded-xl transition inline-flex items-center gap-1.5 shadow-sm">
                                    <i class="fa-solid fa-key"></i> Process Check-Out
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">
                                <i class="fa-solid fa-car-side text-3xl mb-2 text-slate-300 block"></i>
                                Tidak ada booking yang sedang menunggu proses Check-Out.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($bookings->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50">{{ $bookings->links() }}</div>
        @endif
    </div>

</div>
@endsection