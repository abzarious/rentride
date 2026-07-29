@extends('layouts.admin')

@section('title', 'Keranjang Sampah Kendaraan - RentRide')
@section('page_title', 'Kendaraan Dihapus (Trash)')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.vehicles.index') }}" class="p-2 bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 rounded-xl transition">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Sampah Kendaraan</h1>
            <p class="text-xs text-slate-500">Daftar kendaraan yang telah di-soft delete.</p>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm flex items-center justify-between">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-500"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700"><i class="fa-solid fa-xmark"></i></button>
    </div>
@endif

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider">
                    <th class="p-4">KENDARAAN</th>
                    <th class="p-4">PLAT NOMOR</th>
                    <th class="p-4">TANGGAL DIHAPUS</th>
                    <th class="p-4 text-center">AKSI RESTORE / HAPUS PERMANEN</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($trashedVehicles as $vehicle)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="p-4 font-bold text-slate-900">
                            {{ $vehicle->name }}
                            <span class="block text-[11px] font-normal text-slate-400">{{ $vehicle->brand->name ?? '-' }} &bull; {{ $vehicle->color }}</span>
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 bg-slate-100 border border-slate-200 rounded font-mono text-[10px]">{{ $vehicle->plate_number }}</span>
                        </td>
                        <td class="p-4 text-slate-500">
                            {{ $vehicle->deleted_at->format('d M Y, H:i') }} WIB
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <form action="{{ route('admin.vehicles.restore', $vehicle->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 font-bold rounded-lg transition flex items-center gap-1.5 text-xs">
                                        <i class="fa-solid fa-rotate-left"></i> Restore
                                    </button>
                                </form>

                                <form action="{{ route('admin.vehicles.forceDelete', $vehicle->id) }}" method="POST" onsubmit="return confirm('PERINGATAN: Kendaraan ini akan dihapus permanen dari database!');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 font-bold rounded-lg transition flex items-center gap-1.5 text-xs">
                                        <i class="fa-solid fa-ban"></i> Hapus Permanen
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-400">
                            <i class="fa-solid fa-trash-can-arrow-up text-3xl mb-2 text-slate-300"></i>
                            <p class="font-medium text-xs">Tidak ada kendaraan di dalam keranjang sampah.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($trashedVehicles->hasPages())
        <div class="p-4 border-t border-slate-200 bg-slate-50">
            {{ $trashedVehicles->links() }}
        </div>
    @endif
</div>
@endsection