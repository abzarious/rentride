@extends('layouts.admin')

@section('title', 'Daftar Kendaraan - RentRide')
@section('page_title', 'Manajemen Kendaraan')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Armada Kendaraan</h1>
        <p class="text-xs text-slate-500 mt-1">Kelola seluruh armada mobil dan motor yang siap disewakan.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.vehicles.trash') }}" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold rounded-xl transition flex items-center gap-2">
            <i class="fa-solid fa-trash-can text-red-500"></i> Sampah
        </a>
        <a href="{{ route('admin.vehicles.create') }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-slate-900 text-xs font-bold rounded-xl transition flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-plus"></i> Tambah Kendaraan
        </a>
    </div>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm flex items-center justify-between">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
@endif

<div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm mb-6">
    <form method="GET" action="{{ route('admin.vehicles.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
        <div class="lg:col-span-2">
            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Cari Kendaraan</label>
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama kendaraan / Plat nomor..." class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-amber-500">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
            </div>
        </div>

        <div>
            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Brand</label>
            <select name="brand_id" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-amber-500">
                <option value="">-- Semua Brand --</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Kategori</label>
            <select name="category_id" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-amber-500">
                <option value="">-- Semua Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-end gap-2">
            <div class="flex-1">
                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-amber-500">
                    <option value="">-- Semua --</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="booked" {{ request('status') == 'booked' ? 'selected' : '' }}>Booked</option>
                    <option value="rented" {{ request('status') == 'rented' ? 'selected' : '' }}>Rented</option>
                    <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="px-3 py-2 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-slate-800 transition">
                <i class="fa-solid fa-filter"></i>
            </button>
            @if(request()->anyFilled(['search', 'brand_id', 'category_id', 'status']))
                <a href="{{ route('admin.vehicles.index') }}" class="px-3 py-2 bg-slate-200 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-300 transition" title="Reset Filter">
                    <i class="fa-solid fa-rotate"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider">
                    <th class="p-4">KENDARAAN</th>
                    <th class="p-4">BRAND & TIPE</th>
                    <th class="p-4">HARGA / HARI</th>
                    <th class="p-4">STATUS</th>
                    <th class="p-4 text-center">AKSI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($vehicles as $vehicle)
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
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shrink-0 flex items-center justify-center">
                                    @if($vehicle->thumbnail)
                                        <img src="{{ asset('storage/' . $vehicle->thumbnail) }}" alt="{{ $vehicle->name }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fa-solid fa-car text-slate-400 text-lg"></i>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm">{{ $vehicle->name }}</h4>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="px-1.5 py-0.5 bg-slate-100 border border-slate-200 text-slate-600 rounded text-[10px] font-mono uppercase">{{ $vehicle->plate_number }}</span>
                                        <span class="text-slate-400 text-[11px]">{{ $vehicle->year }} &bull; {{ $vehicle->color }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <p class="font-semibold text-slate-800">{{ $vehicle->brand->name ?? '-' }}</p>
                            <p class="text-[11px] text-slate-400">{{ $vehicle->category->name ?? '-' }} &bull; {{ $vehicle->vehicleType->name ?? '-' }}</p>
                        </td>
                        <td class="p-4">
                            <span class="font-bold text-slate-900">Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}</span>
                            <span class="text-[10px] text-slate-400 block">/ 24 jam</span>
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 text-[10px] font-bold rounded-full border uppercase tracking-wider {{ $badgeClasses }}">
                                {{ $statusStr }}
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('admin.vehicles.images.index', $vehicle->id) }}" 
                                class="px-2.5 py-1.5 bg-blue-50 text-blue-600 border border-blue-200 rounded-lg text-xs font-semibold hover:bg-blue-600 hover:text-white transition inline-flex items-center gap-1"
                                title="Kelola Galeri Foto">
                                    <i class="fa-solid fa-images"></i> Galeri
                                </a>
                                <a href="{{ route('admin.vehicles.show', $vehicle->id) }}" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition" title="Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" class="p-2 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded-lg transition" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                
                                <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" method="POST" onsubmit="return confirm('Pindahkan kendaraan ini ke Sampah?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition" title="Hapus ke Sampah">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-400">
                            <i class="fa-solid fa-car-rear text-3xl mb-2 text-slate-300"></i>
                            <p class="font-medium text-xs">Belum ada kendaraan yang sesuai kriteria pencarian.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($vehicles->hasPages())
        <div class="p-4 border-t border-slate-200 bg-slate-50">
            {{ $vehicles->links() }}
        </div>
    @endif
</div>
@endsection