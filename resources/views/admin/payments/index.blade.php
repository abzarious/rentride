@extends('layouts.admin')

@section('title', 'Verifikasi Pembayaran - RentRide')
@section('page_title', 'Kelola Verifikasi Pembayaran')

@section('content')
<div class="space-y-6">

    @if(session('success'))
    <x-alerts.alert type="success">{{ session('success') }}</x-alerts.alert>
    @endif

    <div class="flex flex-wrap gap-2 pb-2 border-b border-slate-200 text-xs font-semibold">
        <a href="{{ route('admin.payments.index', ['status' => 'all']) }}"
            class="px-4 py-2 rounded-xl transition {{ $status === 'all' ? 'bg-amber-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100' }}">
            Semua ({{ $counts['all'] }})
        </a>
        <a href="{{ route('admin.payments.index', ['status' => 'pending']) }}"
            class="px-4 py-2 rounded-xl transition {{ $status === 'pending' ? 'bg-amber-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100' }}">
            Menunggu Verifikasi ({{ $counts['pending'] }})
        </a>
        <a href="{{ route('admin.payments.index', ['status' => 'approved']) }}"
            class="px-4 py-2 rounded-xl transition {{ $status === 'approved' ? 'bg-amber-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100' }}">
            Disetujui ({{ $counts['approved'] }})
        </a>
        <a href="{{ route('admin.payments.index', ['status' => 'rejected']) }}"
            class="px-4 py-2 rounded-xl transition {{ $status === 'rejected' ? 'bg-amber-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100' }}">
            Ditolak ({{ $counts['rejected'] }})
        </a>
    </div>

    <x-tables.table>
        <x-slot name="head">
            <tr>
                <th class="p-3">NO. INVOICE</th>
                <th class="p-3">CUSTOMER</th>
                <th class="p-3">KENDARAAN</th>
                <th class="p-3">DURASI</th>
                <th class="p-3">TOTAL TAGIHAN</th>
                <th class="p-3">STATUS</th>
                <th class="p-3 text-right">AKSI</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @forelse($payments as $p)
            <tr>
                <td class="p-3 font-bold text-amber-600">{{ $p->invoice_number }}</td>
                <td class="p-3">
                    <span class="font-bold text-slate-800 block">{{ $p->user->name ?? '-' }}</span>
                    <span class="text-[10px] text-slate-400">{{ $p->user->phone ?? $p->user->email }}</span>
                </td>
                <td class="p-3 font-semibold text-slate-700">{{ $p->vehicle->name ?? '-' }}</td>
                <td class="p-3 text-slate-600">{{ $p->duration_days }} Hari</td>
                <td class="p-3 font-bold text-slate-800">Rp {{ number_format($p->total_price, 0, ',', '.') }}</td>
                <td class="p-3"><x-badges.status-badge :status="$p->status" /></td>
                <td class="p-3 text-right">
                    <a href="{{ route('admin.payments.show', $p->id) }}"
                        class="px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white rounded-lg text-xs font-bold transition inline-flex items-center gap-1">
                        <i class="fa-solid fa-file-invoice"></i> Verifikasi
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="p-6 text-center text-slate-400 text-xs">Belum ada transaksi pembayaran yang
                    memerlukan verifikasi.</td>
            </tr>
            @endforelse
        </x-slot>
    </x-tables.table>

    <div>{{ $payments->links() }}</div>

</div>
@endsection