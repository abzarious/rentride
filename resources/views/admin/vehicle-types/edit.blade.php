@extends('layouts.admin')

@section('title', 'Edit Tipe Kendaraan - RentRide')
@section('page_title', 'Edit Tipe Kendaraan')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('admin.vehicle-types.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-slate-800 mb-4 transition">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Tipe
    </a>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-lg font-bold text-slate-800 mb-1">Perbarui Tipe Kendaraan</h2>
        <p class="text-xs text-slate-500 mb-6">Ubah informasi nama tipe atau deskripsi tipe kendaraan.</p>

        <form action="{{ route('admin.vehicle-types.update', $vehicleType->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-xs font-semibold text-slate-700 uppercase mb-2">Nama Tipe Kendaraan <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $vehicleType->name) }}" class="w-full px-4 py-2.5 bg-slate-50 border @error('name') border-red-500 @else border-slate-200 @enderror rounded-xl text-xs text-slate-800 focus:outline-none focus:border-amber-500 transition">
                @error('name')
                    <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase mb-2">Slug Saat Ini</label>
                <input type="text" value="{{ $vehicleType->slug }}" disabled class="w-full px-4 py-2 bg-slate-100 border border-slate-200 rounded-xl text-xs text-slate-500 font-mono cursor-not-allowed">
            </div>

            <div>
                <label for="description" class="block text-xs font-semibold text-slate-700 uppercase mb-2">Deskripsi (Opsional)</label>
                <textarea name="description" id="description" rows="4" class="w-full px-4 py-2.5 bg-slate-50 border @error('description') border-red-500 @else border-slate-200 @enderror rounded-xl text-xs text-slate-800 focus:outline-none focus:border-amber-500 transition">{{ old('description', $vehicleType->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.vehicle-types.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-xl shadow-md transition flex items-center gap-1.5">
                    <i class="fa-solid fa-pen-to-square"></i> Perbarui Tipe
                </button>
            </div>
        </form>
    </div>
</div>
@endsection