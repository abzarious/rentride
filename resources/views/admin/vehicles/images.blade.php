@extends('layouts.admin')

@section('title', 'Galeri Foto - ' . $vehicle->name)
@section('page_title', 'Kelola Galeri Foto Kendaraan')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <a href="{{ route('admin.vehicles.index') }}" class="text-xs font-semibold text-amber-600 hover:underline mb-2 inline-block">
            <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Daftar Kendaraan
        </a>
        <h1 class="text-2xl font-bold text-slate-800">{{ $vehicle->name }}</h1>
        <p class="text-xs text-slate-500 mt-1">
            Plat: <span class="font-semibold text-slate-700">{{ $vehicle->plate_number }}</span> | 
            Brand: <span class="font-semibold text-slate-700">{{ $vehicle->brand->name ?? '-' }}</span> | 
            Kategori: <span class="font-semibold text-slate-700">{{ $vehicle->category->name ?? '-' }}</span>
        </p>
    </div>
    <div>
        <x-badges.status-badge :status="$vehicle->status->value" />
    </div>
</div>

@if(session('success'))
    <div class="mb-6">
        <x-alerts.alert type="success">
            {{ session('success') }}
        </x-alerts.alert>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm sticky top-20">
            <h3 class="text-base font-bold text-slate-800 mb-2 flex items-center gap-2">
                <i class="fa-solid fa-cloud-arrow-up text-amber-500"></i> Upload Foto Baru
            </h3>
            <p class="text-xs text-slate-500 mb-4">Unggah satu atau beberapa foto sekaligus (tampak depan, samping, interior, dll).</p>

            <form action="{{ route('admin.vehicles.images.store', $vehicle->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-2">Pilih File Gambar</label>
                    <input type="file" name="images[]" id="images" multiple accept="image/*"
                           class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 border border-slate-200 rounded-xl cursor-pointer">
                    <p class="text-[11px] text-slate-400 mt-1.5">Format: JPG, PNG, WEBP (Max 2MB per foto)</p>
                    @error('images')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    @error('images.*')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <x-buttons.primary-button type="submit" class="w-full">
                    <i class="fa-solid fa-upload"></i> Unggah Gambar
                </x-buttons.primary-button>
            </form>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <h3 class="text-base font-bold text-slate-800 mb-4 flex items-center justify-between">
                <span><i class="fa-solid fa-images text-slate-600 mr-2"></i> Galeri Foto Kendaraan</span>
                <span class="text-xs font-normal text-slate-500">Total: {{ $vehicle->images->count() + ($vehicle->thumbnail ? 1 : 0) }} Foto</span>
            </h3>

            <div class="mb-6 p-4 bg-slate-50 rounded-xl border border-slate-200">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block mb-2">Foto Utama (Thumbnail Kendaraan)</span>
                @if($vehicle->thumbnail)
                    <div class="relative w-full h-56 rounded-lg overflow-hidden border border-slate-300 group">
                        <img src="{{ asset('storage/' . $vehicle->thumbnail) }}" alt="{{ $vehicle->name }}" class="w-full h-full object-cover">
                        <span class="absolute top-2 left-2 bg-amber-500 text-slate-900 text-[10px] font-bold px-2 py-0.5 rounded-md shadow">
                            UTAMA
                        </span>
                    </div>
                @else
                    <div class="w-full h-32 bg-slate-200 rounded-lg flex items-center justify-center text-slate-400 text-xs">
                        Belum ada thumbnail utama
                    </div>
                @endif
            </div>

            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Foto Tambahan Galeri</h4>

            @if($vehicle->images->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @foreach($vehicle->images as $img)
                        <div class="relative group rounded-xl overflow-hidden border border-slate-200 shadow-sm bg-slate-900 h-40">
                            <img src="{{ asset('storage/' . $img->image_path) }}" alt="Foto {{ $vehicle->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300 opacity-90 group-hover:opacity-100">
                            
                            <div class="absolute inset-0 bg-slate-950/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2 p-2">
                                <form action="{{ route('admin.vehicle-images.destroy', $img->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-lg shadow transition flex items-center gap-1">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <x-empty.empty-data 
                    title="Belum Ada Foto Galeri" 
                    description="Kendaraan ini belum memiliki foto tambahan di galeri. Gunakan form di sebelah kiri untuk mengunggah foto.">
                </x-empty.empty-data>
            @endif

        </div>
    </div>

</div>
@endsection