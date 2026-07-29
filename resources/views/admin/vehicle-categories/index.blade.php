@extends('layouts.admin')

@section('title', 'Kategori Kendaraan - RentRide Admin')
@section('page_title', 'Master Data Kategori Kendaraan')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Daftar Kategori Kendaraan</h1>
        <p class="text-xs text-slate-500 mt-1">Kelola kategori utama untuk pengelompokan jenis kendaraan rental.</p>
    </div>
    <a href="{{ route('admin.vehicle-categories.create') }}" class="px-4 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-xl transition shadow-md shadow-amber-600/20 flex items-center justify-center gap-2">
        <i class="fa-solid fa-plus"></i> Tambah Kategori
    </a>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm flex items-center justify-between">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-600"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm flex items-center justify-between">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation text-red-600"></i>
            <span>{{ session('error') }}</span>
        </div>
    </div>
@endif

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.vehicle-categories.index') }}" class="w-full sm:w-72 relative">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari kategori..." 
                class="w-full pl-9 pr-4 py-2 text-xs bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:outline-none">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
        </form>
        @if($search)
            <a href="{{ route('admin.vehicle-categories.index') }}" class="text-xs text-amber-600 hover:underline">Reset Pencarian</a>
        @endif
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="bg-slate-100/70 border-b border-slate-200 text-slate-600 text-xs font-semibold uppercase">
                    <th class="p-4">No</th>
                    <th class="p-4">Nama Kategori</th>
                    {{-- <th class="p-4">Slug</th> --}}
                    <th class="p-4">Status</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($categories as $index => $category)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="p-4 font-medium text-slate-500">{{ $categories->firstItem() + $index }}</td>
                        <td class="p-4 font-semibold text-slate-800">{{ $category->name }}</td>
                        {{-- <td class="p-4 text-slate-500 font-mono text-xs">{{ $category->slug }}</td> --}}
                        <td class="p-4">
                            @if($category->status)
                                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-full">Aktif</span>
                            @else
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-600 text-xs font-semibold rounded-full">Nonaktif</span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.vehicle-categories.edit', $category->id) }}" class="p-2 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-600 hover:text-white transition text-xs" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.vehicle-categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition text-xs" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <i class="fa-solid fa-folder-open text-3xl"></i>
                                <p class="text-sm">Belum ada data kategori kendaraan ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categories->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $categories->links() }}
        </div>
    @endif
</div>
@endsection