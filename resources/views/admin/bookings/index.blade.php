@extends('layouts.admin')

@section('title', 'Manajemen Booking - RentRide')
@section('page_title', 'Kelola Transaksi Booking')

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <x-alerts.alert type="success">{{ session('success') }}</x-alerts.alert>
    @endif

    <div class="flex flex-wrap gap-2 pb-2 border-b border-slate-200 text-xs font-semibold">
        <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2 rounded-xl transition {{ !$status ? 'bg-amber-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100' }}">
            Semua ({{ $counts['all'] }})
        </a>
        <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-xl transition {{ $status === 'pending' ? 'bg-amber-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100' }}">
            Menunggu WA ({{ $counts['pending'] }})
        </a>
        <a href="{{ route('admin.bookings.index', ['status' => 'approved']) }}" class="px-4 py-2 rounded-xl transition {{ $status === 'approved' ? 'bg-amber-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100' }}">
            Disetujui ({{ $counts['approved'] }})
        </a>
        <a href="{{ route('admin.bookings.index', ['status' => 'ongoing']) }}" class="px-4 py-2 rounded-xl transition {{ $status === 'ongoing' ? 'bg-amber-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100' }}">
            Sedang Dirental ({{ $counts['ongoing'] }})
        </a>
        <a href="{{ route('admin.bookings.index', ['status' => 'completed']) }}" class="px-4 py-2 rounded-xl transition {{ $status === 'completed' ? 'bg-amber-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100' }}">
            Selesai ({{ $counts['completed'] }})
        </a>
    </div>

    <x-tables.table>
        <x-slot name="head">
            <tr>
                <th class="p-3">INVOICE</th>
                <th class="p-3">CUSTOMER</th>
                <th class="p-3">KENDARAAN</th>
                <th class="p-3">PERIODE RENTAL</th>
                <th class="p-3">TOTAL BIAYA</th>
                <th class="p-3">STATUS</th>
                <th class="p-3 text-right">AKSI</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @forelse($bookings as $b)
                <tr>
                    <td class="p-3 font-bold text-amber-600">{{ $b->invoice_number }}</td>
                    <td class="p-3">
                        <span class="font-bold text-slate-800 block">{{ $b->user->name ?? '-' }}</span>
                        <span class="text-[10px] text-slate-400">{{ $b->user->phone ?? $b->user->email ?? '' }}</span>
                    </td>
                    <td class="p-3 font-semibold text-slate-700">{{ $b->vehicle->name ?? '-' }}</td>
                    <td class="p-3 text-xs text-slate-600">
                        {{ $b->start_date->format('d/m/Y H:i') }} - {{ $b->end_date->format('d/m/Y H:i') }}
                    </td>
                    <td class="p-3 font-bold text-slate-800">Rp {{ number_format($b->total_price, 0, ',', '.') }}</td>
                    <td class="p-3"><x-badges.status-badge :status="$b->status" /></td>
                    <td class="p-3 text-right">
                        <a href="{{ route('admin.bookings.show', $b->id) }}" class="px-3 py-1 bg-slate-800 hover:bg-slate-700 text-white rounded-lg text-xs font-bold transition">
                            Kelola
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="p-6 text-center text-slate-400 text-xs">Belum ada data transaksi booking.</td>
                </tr>
            @endforelse
        </x-slot>
    </x-tables.table>

    <div>{{ $bookings->links() }}</div>

</div>
@endsection