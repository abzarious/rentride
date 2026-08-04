@extends('layouts.customer')

@section('title', 'Riwayat Rental - RentRide')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Riwayat Rental Selesai & Dibatalkan</h1>
            <p class="text-xs text-gray-400">Arsip seluruh transaksi rental yang telah selesai atau dibatalkan.</p>
        </div>
    </div>

    @if($bookings->count() > 0)
        <x-tables.table>
            <x-slot name="head">
                <tr>
                    <th class="p-3">INVOICE</th>
                    <th class="p-3">ARMADA</th>
                    <th class="p-3">TANGGAL RENTAL</th>
                    <th class="p-3">DURASI</th>
                    <th class="p-3">TOTAL BIAYA</th>
                    <th class="p-3">STATUS</th>
                    <th class="p-3 text-right">AKSI</th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach($bookings as $b)
                <tr>
                    <td class="p-3 font-bold text-[#D97706]">{{ $b->invoice_number }}</td>
                    <td class="p-3 text-white font-medium">{{ $b->vehicle->name }}</td>
                    <td class="p-3 text-xs text-gray-400">{{ $b->start_date->format('d M Y') }}</td>
                    <td class="p-3 text-xs text-gray-400">{{ $b->duration_days }} Hari</td>
                    <td class="p-3 font-semibold text-white">Rp {{ number_format($b->total_price, 0, ',', '.') }}</td>
                    <td class="p-3"><x-badges.status-badge :status="$b->status" /></td>
                    <td class="p-3 text-right">
                        <a href="{{ route('customer.bookings.show', $b->id) }}" class="px-3 py-1 bg-gray-800 hover:bg-gray-700 text-gray-300 rounded-lg text-xs font-semibold">
                            Rincian
                        </a>
                    </td>
                </tr>
                @endforeach
            </x-slot>
        </x-tables.table>

        <div class="mt-6">
            {{ $bookings->links() }}
        </div>
    @else
        <x-empty.empty-data title="Riwayat Kosong" description="Belum ada riwayat transaksi rental yang telah selesai." />
    @endif

</div>
@endsection