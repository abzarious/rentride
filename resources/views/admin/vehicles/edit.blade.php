@extends('layouts.admin')

@section('title', 'Edit Kendaraan - RentRide')
@section('page_title', 'Edit Data Kendaraan')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Edit Armada: {{ $vehicle->name }}</h1>
            <p class="text-xs text-slate-500 mt-1">Perbarui informasi kendaraan di bawah ini.</p>
        </div>
        <a href="{{ route('admin.vehicles.index') }}" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-semibold rounded-xl transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
        <form action="{{ route('admin.vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="brand_id" class="block text-xs font-bold text-slate-700 uppercase mb-2">Brand <span class="text-red-500">*</span></label>
                    <select name="brand_id" id="brand_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:bg-white transition @error('brand_id') border-red-500 @enderror">
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id', $vehicle->brand_id) == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('brand_id')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-xs font-bold text-slate-700 uppercase mb-2">Kategori <span class="text-red-500">*</span></label>
                    <select name="category_id" id="category_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:bg-white transition @error('category_id') border-red-500 @enderror">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $vehicle->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="vehicle_type_id" class="block text-xs font-bold text-slate-700 uppercase mb-2">Tipe Kendaraan <span class="text-red-500">*</span></label>
                    <select name="vehicle_type_id" id="vehicle_type_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:bg-white transition @error('vehicle_type_id') border-red-500 @enderror">
                        @foreach($types as $type)
                            <option value="{{ $type->id }}" {{ old('vehicle_type_id', $vehicle->vehicle_type_id) == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('vehicle_type_id')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase mb-2">Nama Kendaraan <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $vehicle->name) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:bg-white transition @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="plate_number" class="block text-xs font-bold text-slate-700 uppercase mb-2">Plat Nomor <span class="text-red-500">*</span></label>
                    <input type="text" name="plate_number" id="plate_number" value="{{ old('plate_number', $vehicle->plate_number) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:bg-white transition @error('plate_number') border-red-500 @enderror">
                    @error('plate_number')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label for="year" class="block text-xs font-bold text-slate-700 uppercase mb-2">Tahun <span class="text-red-500">*</span></label>
                    <input type="number" name="year" id="year" value="{{ old('year', $vehicle->year) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:bg-white transition @error('year') border-red-500 @enderror">
                    @error('year')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="color" class="block text-xs font-bold text-slate-700 uppercase mb-2">Warna <span class="text-red-500">*</span></label>
                    <input type="text" name="color" id="color" value="{{ old('color', $vehicle->color) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:bg-white transition @error('color') border-red-500 @enderror">
                    @error('color')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price_per_day" class="block text-xs font-bold text-slate-700 uppercase mb-2">Harga / Hari (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="price_per_day" id="price_per_day" value="{{ old('price_per_day', $vehicle->price_per_day) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:bg-white transition @error('price_per_day') border-red-500 @enderror">
                    @error('price_per_day')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-xs font-bold text-slate-700 uppercase mb-2">Status Armada <span class="text-red-500">*</span></label>
                    <select name="status" id="status" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:bg-white transition @error('status') border-red-500 @enderror">
                        @foreach($statuses as $status)
                            <option value="{{ $status->value }}" {{ old('status', $vehicle->status->value ?? $vehicle->status) == $status->value ? 'selected' : '' }}>
                                {{ ucfirst($status->value) }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="transmission" class="block text-xs font-bold text-slate-700 uppercase mb-2">Transmisi <span class="text-red-500">*</span></label>
                    <select name="transmission" id="transmission" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:bg-white transition @error('transmission') border-red-500 @enderror">
                        <option value="Automatic" {{ old('transmission', $vehicle->transmission) == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                        <option value="Manual" {{ old('transmission', $vehicle->transmission) == 'Manual' ? 'selected' : '' }}>Manual</option>
                    </select>
                    @error('transmission')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="fuel_type" class="block text-xs font-bold text-slate-700 uppercase mb-2">Bahan Bakar <span class="text-red-500">*</span></label>
                    <select name="fuel_type" id="fuel_type" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:bg-white transition @error('fuel_type') border-red-500 @enderror">
                        <option value="Bensin" {{ old('fuel_type', $vehicle->fuel_type) == 'Bensin' ? 'selected' : '' }}>Bensin</option>
                        <option value="Diesel" {{ old('fuel_type', $vehicle->fuel_type) == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                        <option value="Listrik" {{ old('fuel_type', $vehicle->fuel_type) == 'Listrik' ? 'selected' : '' }}>Listrik</option>
                    </select>
                    @error('fuel_type')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="thumbnail" class="block text-xs font-bold text-slate-700 uppercase mb-2">Ganti Foto Utama (Optional)</label>
                
                @if($vehicle->thumbnail)
                    <div class="mb-3 flex items-center gap-4">
                        <img src="{{ asset('storage/' . $vehicle->thumbnail) }}" alt="{{ $vehicle->name }}" class="w-20 h-20 object-cover rounded-xl border border-slate-200">
                        <span class="text-xs text-slate-500">Foto saat ini terpasang. Pilih foto baru di bawah jika ingin mengganti.</span>
                    </div>
                @endif

                <input type="file" name="thumbnail" id="thumbnail" accept="image/*" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-amber-500 file:text-slate-900 hover:file:bg-amber-600 transition">
                @error('thumbnail')
                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-xs font-bold text-slate-700 uppercase mb-2">Deskripsi / Catatan Kendaraan</label>
                <textarea name="description" id="description" rows="4" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:bg-white transition">{{ old('description', $vehicle->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.vehicles.index') }}" class="px-5 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold rounded-xl text-xs transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl text-xs shadow-md shadow-amber-600/20 transition flex items-center gap-2">
                    <i class="fa-solid fa-arrows-rotate"></i> Perbarui Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection