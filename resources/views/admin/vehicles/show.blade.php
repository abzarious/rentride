@extends('layouts.admin')

@section('title', 'Detail Kendaraan - RentRide')
@section('page_title', 'Detail Kendaraan')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.vehicles.index') }}" class="p-2 bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 rounded-xl transition">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">{{ $vehicle->name }}</h1>
            <p class="text-xs text-slate-500">Plat Nomor: <span class="font-mono font-bold text-slate-700 uppercase">{{ $vehicle->plate_number }}</span></p>
        </div>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-slate-900 text-xs font-bold rounded-xl transition flex items-center gap-2">
            <i class="fa-solid fa-pen-to-square"></i> Edit Kendaraan
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col items-center">
        <div class="w-full h-56 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center mb-4">
            @if($vehicle->thumbnail)
                <img src="{{ asset('storage/' . $vehicle->thumbnail) }}" alt="{{ $vehicle->name }}" class="w-full h-full object-cover">
            @else
                <div class="text-center text-slate-400">
                    <i class="fa-solid fa-car text-4xl mb-2"></i>
                    <p class="text-xs">Tidak ada foto utama</p>
                </div>
            @endif
        </div>

        @php
            $statusStr = is_object($vehicle->status) ? $vehicle->status->value : $vehicle->status;
            $badgeClasses = match($statusStr) {
                'available' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                'booked' => 'bg-amber-100 text-amber-700 border-amber-200',
                'rented' => 'bg-blue-100 text-blue-700 border-blue-200',
                'maintenance' => 'bg-purple-100 text-purple-700 border-purple-200',
                default => 'bg-slate-100 text-slate-600 border-slate-200',
            };
        @endphp

        <div class="w-full flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-200">
            <span class="text-xs font-semibold text-slate-500">Status Operasional</span>
            <span class="px-3 py-1 text-xs font-bold rounded-full border uppercase tracking-wider {{ $badgeClasses }}">
                {{ $statusStr }}
            </span>
        </div>
    </div>

    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-base font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">Spesifikasi Kendaraan</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <span class="text-slate-400 block mb-0.5">Brand / Merk</span>
                    <span class="font-bold text-slate-800 text-sm">{{ $vehicle->brand->name ?? '-' }}</span>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <span class="text-slate-400 block mb-0.5">Kategori & Tipe</span>
                    <span class="font-bold text-slate-800 text-sm">{{ $vehicle->category->name ?? '-' }} &bull; {{ $vehicle->vehicleType->name ?? '-' }}</span>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <span class="text-slate-400 block mb-0.5">Tahun Pembuatan</span>
                    <span class="font-bold text-slate-800 text-sm">{{ $vehicle->year }}</span>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <span class="text-slate-400 block mb-0.5">Warna</span>
                    <span class="font-bold text-slate-800 text-sm">{{ $vehicle->color }}</span>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <span class="text-slate-400 block mb-0.5">Transmisi</span>
                    <span class="font-bold text-slate-800 text-sm">{{ $vehicle->transmission }}</span>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <span class="text-slate-400 block mb-0.5">Bahan Bakar</span>
                    <span class="font-bold text-slate-800 text-sm">{{ $vehicle->fuel_type }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-base font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">Harga Sewa & Deskripsi</h3>
            
            <div class="mb-4 p-4 bg-amber-50 border border-amber-200 rounded-xl flex items-center justify-between">
                <div>
                    <span class="text-xs text-amber-700 font-medium">Tarif Sewa Harian (24 Jam)</span>
                    <h2 class="text-2xl font-black text-amber-900 mt-0.5">Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}</h2>
                </div>
                <i class="fa-solid fa-tags text-2xl text-amber-500"></i>
            </div>

            <div>
                <span class="text-xs font-semibold text-slate-500 block mb-1">Deskripsi Tambahan:</span>
                <p class="text-xs text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-xl border border-slate-100">
                    {{ $vehicle->description ?? 'Belum ada deskripsi yang ditambahkan untuk kendaraan ini.' }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection