@extends('layouts.admin')

@section('title', 'Manajemen Brand - RentRide')
@section('page_title', 'Master Data Brand')

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2 font-medium">
                <i class="fa-solid fa-circle-check text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
    @endif

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Daftar Brand Kendaraan</h3>
            <p class="text-xs text-slate-500 mt-1">Kelola merk/pabrikan mobil dan motor yang terdaftar di sistem.</p>
        </div>
        
        <div class="flex flex-col sm:flex-row items-center gap-3">
            <form method="GET" action="{{ route('admin.brands.index') }}" class="w-full sm:w-auto flex items-center gap-2">
                <div class="relative w-full sm:w-64">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Cari brand..." 
                           class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-amber-500 focus:outline-none transition">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                </div>
                @if(request('search'))
                    <a href="{{ route('admin.brands.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition">
                        Reset
                    </a>
                @endif
            </form>

            <a href="{{ route('admin.brands.create') }}" class="w-full sm:w-auto px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-xl transition shadow-sm flex items-center justify-center gap-2">
                <i class="fa-solid fa-plus"></i> Tambah Brand
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm text-slate-700">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase">
                    <tr>
                        <th class="p-4 w-16 text-center">NO</th>
                        <th class="p-4">NAMA BRAND</th>
                        {{-- <th class="p-4">SLUG</th> --}}
                        <th class="p-4">TANGGAL DIBUAT</th>
                        <th class="p-4 text-center w-36">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($brands as $index => $brand)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="p-4 text-center text-xs font-semibold text-slate-400">
                                {{ $brands->firstItem() + $index }}
                            </td>
                            <td class="p-4 font-bold text-slate-800">
                                {{ $brand->name }}
                            </td>
                            {{-- <td class="p-4 text-xs font-mono text-slate-500">
                                {{ $brand->slug }}
                            </td> --}}
                            <td class="p-4 text-xs text-slate-500">
                                {{ $brand->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.brands.edit', $brand->id) }}" class="p-2 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded-lg text-xs font-bold transition" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus brand {{ $brand->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-xs font-bold transition" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400">
                                <div class="w-12 h-12 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fa-solid fa-layer-group text-xl"></i>
                                </div>
                                <p class="text-sm font-semibold text-slate-600">Belum Ada Data Brand</p>
                                <p class="text-xs text-slate-400 mt-1">Silakan klik tombol "Tambah Brand" untuk menambahkan data baru.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($brands->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $brands->links() }}
            </div>
        @endif
    </div>

</div>
@endsection