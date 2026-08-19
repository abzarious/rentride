@extends('layouts.admin')

@section('title', 'Pengembalian Kendaraan - RentRide')
@section('page_title', 'Daftar Pengembalian Kendaraan (Check-In)')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Kendaraan Sedang Disewa</h1>
            <p class="text-xs text-slate-500 mt-1">Daftar kendaraan yang saat ini di tangan penyewa dan siap diproses pengembaliannya (Check-In).</p>
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

    @if(session('error'))
        <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-xs font-semibold flex items-center justify-between">
            <span><i class="fa-solid fa-triangle-exclamation text-red-500 mr-2"></i> {{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="text-red-500"><i class="fa-solid fa-xmark"></i></button>
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
                        <th class="p-4">WAKTU CHECK-OUT</th>
                        <th class="p-4">RENCANA KEMBALI</th>
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
                                <span class="font-mono text-[10px] text-slate-500 bg-slate-100 px-1.5 py-0.5 rounded border">{{ $b->vehicle->plate_number }}</span>
                            </td>
                            <td class="p-4">
                                <p class="font-medium text-slate-800">{{ $b->checked_out_at?->format('d/m/Y H:i') ?? '-' }} WIB</p>
                                <p class="text-[10px] text-slate-400">Oleh: {{ $b->checkedOutBy->name ?? 'Admin' }}</p>
                            </td>
                            <td class="p-4">
                                <p class="font-bold text-slate-800">{{ $b->end_date->format('d/m/Y H:i') }} WIB</p>
                                @if(now()->greaterThan($b->end_date))
                                    <span class="text-[10px] font-bold text-red-600 bg-red-50 border border-red-200 px-2 py-0.5 rounded-full inline-block mt-0.5">
                                        <i class="fa-solid fa-triangle-exclamation"></i> Terlambat Kembali
                                    </span>
                                @else
                                    <span class="text-[10px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full inline-block mt-0.5">
                                        Dalam Masa Sewa
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <a href="{{ route('admin.bookings.show', $b->id) }}" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition inline-flex items-center gap-1.5 shadow-sm">
                                    <i class="fa-solid fa-right-to-bracket"></i> Proses Pengembalian
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">
                                <i class="fa-solid fa-road text-3xl mb-2 text-slate-300 block"></i>
                                Tidak ada kendaraan yang sedang dirental saat ini.
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