@extends('layouts.admin')

@section('title', 'Master Tipe Kendaraan - RentRide')
@section('page_title', 'Master Tipe Kendaraan')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Daftar Tipe Kendaraan</h1>
        <p class="text-xs text-slate-500 mt-1">Kelola jenis dan varian tipe kendaraan (SUV, MPV, Scooter, dsb).</p>
    </div>
    <a href="{{ route('admin.vehicle-types.create') }}" class="px-4 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-xl shadow-md transition flex items-center justify-center gap-2 w-fit">
        <i class="fa-solid fa-plus"></i> Tambah Tipe Kendaraan
    </a>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-medium flex items-center justify-between">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
@endif

<div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm mb-6">
    <form method="GET" action="{{ route('admin.vehicle-types.index') }}" class="flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama tipe atau deskripsi..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-700 focus:outline-none focus:border-amber-500 transition">
        </div>
        <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-semibold rounded-lg transition flex items-center justify-center gap-1.5">
            <i class="fa-solid fa-filter"></i> Cari
        </button>
        @if(request('search'))
            <a href="{{ route('admin.vehicle-types.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-lg transition flex items-center justify-center">
                Reset
            </a>
        @endif
    </form>
</div>

<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider">
                    <th class="p-4 w-16 text-center">NO</th>
                    <th class="p-4">NAMA TIPE</th>
                    <th class="p-4">DESKRIPSI</th>
                    <th class="p-4 text-center w-36">AKSI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($vehicleTypes as $index => $type)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="p-4 text-center font-semibold text-slate-500">
                            {{ $vehicleTypes->firstItem() + $index }}
                        </td>
                        <td class="p-4 font-bold text-slate-800">
                            {{ $type->name }}
                        </td>
                        <td class="p-4 text-slate-500 max-w-xs truncate">
                            {{ $type->description ?? '-' }}
                        </td>
                        <td class="p-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.vehicle-types.edit', $type->id) }}" class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-600 hover:text-white rounded-lg transition" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                
                                <form action="{{ route('admin.vehicle-types.destroy', $type->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tipe {{ $type->name }}?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-lg transition" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-400">
                            <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400 text-lg">
                                <i class="fa-solid fa-folder-open"></i>
                            </div>
                            <p class="font-semibold text-slate-600">Belum Ada Data Tipe Kendaraan</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">Silakan tambahkan tipe kendaraan baru melalui tombol di atas.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($vehicleTypes->hasPages())
        <div class="p-4 border-t border-slate-100 bg-slate-50">
            {{ $vehicleTypes->links() }}
        </div>
    @endif
</div>
@endsection