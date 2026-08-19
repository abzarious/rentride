@extends('layouts.admin')

@section('title', 'Manajemen Denda - RentRide')
@section('page_title', 'Daftar Denda Keterlambatan')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Denda Keterlambatan Unit</h1>
            <p class="text-xs text-slate-500 mt-1">Rekap data denda yang diterbitkan secara otomatis dari keterlambatan pengembalian armada.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-semibold flex items-center justify-between">
            <span><i class="fa-solid fa-circle-check text-emerald-500 mr-2"></i> {{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-emerald-500"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Denda Terbit</p>
                <h3 class="text-xl font-black text-slate-800 mt-1">Rp {{ number_format($stats['total_amount'], 0, ',', '.') }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">{{ $stats['total_penalties'] }} Transaksi</p>
            </div>
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Belum Dibayar (Unpaid)</p>
                <h3 class="text-xl font-black text-red-600 mt-1">Rp {{ number_format($stats['unpaid_amount'], 0, ',', '.') }}</h3>
                <p class="text-xs text-red-500 font-medium mt-0.5">Menunggu Pelunasan</p>
            </div>
            <div class="w-12 h-12 bg-red-50 text-red-600 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Lunas (Paid)</p>
                <h3 class="text-xl font-black text-emerald-600 mt-1">Rp {{ number_format($stats['paid_amount'], 0, ',', '.') }}</h3>
                <p class="text-xs text-emerald-600 font-medium mt-0.5">Telah Terbayar</p>
            </div>
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] border-b border-slate-200">
                    <tr>
                        <th class="p-4">INVOICE</th>
                        <th class="p-4">CUSTOMER</th>
                        <th class="p-4">KENDARAAN</th>
                        <th class="p-4">DURASI TELAT</th>
                        <th class="p-4">NOMINAL DENDA</th>
                        <th class="p-4">STATUS</th>
                        <th class="p-4 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($penalties as $p)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-bold text-amber-600">{{ $p->booking->invoice_number }}</td>
                            <td class="p-4">
                                <p class="font-bold text-slate-800">{{ $p->booking->user->name }}</p>
                                <p class="text-[10px] text-slate-400">{{ $p->booking->user->phone ?? '-' }}</p>
                            </td>
                            <td class="p-4">
                                <p class="font-bold text-slate-800">{{ $p->booking->vehicle->name }}</p>
                                <span class="font-mono text-[10px] text-slate-500 bg-slate-100 px-1.5 py-0.5 rounded border">{{ $p->booking->vehicle->plate_number }}</span>
                            </td>
                            <td class="p-4 font-bold text-slate-800">
                                {{ $p->late_hours }} Jam <span class="text-[10px] text-slate-400">({{ $p->late_minutes }} menit)</span>
                            </td>
                            <td class="p-4 font-black text-red-600">
                                Rp {{ number_format($p->amount, 0, ',', '.') }}
                            </td>
                            <td class="p-4">
                                @if($p->status === 'paid')
                                    <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 rounded-full text-[10px] font-extrabold uppercase">Lunas</span>
                                @else
                                    <span class="px-2.5 py-1 bg-red-100 text-red-800 rounded-full text-[10px] font-extrabold uppercase">Belum Bayar</span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <a href="{{ route('admin.penalties.show', $p->id) }}" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-900 text-white text-[11px] font-bold rounded-xl transition inline-flex items-center gap-1">
                                    <i class="fa-solid fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400">
                                <i class="fa-solid fa-shield-check text-3xl mb-2 text-slate-300 block"></i>
                                Belum ada catatan denda keterlambatan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($penalties->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50">{{ $penalties->links() }}</div>
        @endif
    </div>

</div>
@endsection