@extends('layouts.customer')

@section('title', $vehicle->name . ' - Detail Kendaraan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <nav class="flex text-xs text-gray-400 mb-6 gap-2">
        <a href="/" class="hover:text-[#D97706]">Beranda</a>
        <span>/</span>
        <a href="#" class="hover:text-[#D97706]">{{ $vehicle->category->name ?? 'Kategori' }}</a>
        <span>/</span>
        <span class="text-white font-semibold">{{ $vehicle->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-7">
            <div class="bg-[#111827] border border-gray-800 rounded-2xl overflow-hidden shadow-2xl relative">
                @if($vehicle->thumbnail)
                    <img id="mainImage" src="{{ asset('storage/' . $vehicle->thumbnail) }}" alt="{{ $vehicle->name }}" class="w-full h-96 object-cover transition-all duration-300">
                @else
                    <div class="w-full h-96 bg-gray-900 flex items-center justify-center text-gray-600">
                        <i class="fa-solid fa-car text-6xl"></i>
                    </div>
                @endif

                <div class="absolute top-4 right-4">
                    <x-badges.status-badge :status="$vehicle->status" />
                </div>
            </div>

            @if($vehicle->images && $vehicle->images->count() > 0)
                <div class="grid grid-cols-4 gap-3 mt-4">
                    <div onclick="changeImage('{{ asset('storage/' . $vehicle->thumbnail) }}')" class="cursor-pointer border-2 border-[#D97706] rounded-xl overflow-hidden h-20 bg-gray-900 hover:opacity-80 transition">
                        <img src="{{ asset('storage/' . $vehicle->thumbnail) }}" class="w-full h-full object-cover">
                    </div>
                    @foreach($vehicle->images as $img)
                        <div onclick="changeImage('{{ asset('storage/' . $img->image) }}')" class="cursor-pointer border border-gray-800 hover:border-[#D97706] rounded-xl overflow-hidden h-20 bg-gray-900 hover:opacity-80 transition">
                            <img src="{{ asset('storage/' . $img->image) }}" class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="lg:col-span-5">
            <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-xl sticky top-24">
                
                <div class="border-b border-gray-800 pb-4 mb-4">
                    <span class="text-xs font-bold text-[#D97706] uppercase tracking-wider">
                        {{ $vehicle->brand->name ?? 'Brand' }} &bull; {{ $vehicle->vehicleType->name ?? $vehicle->type->name ?? 'Tipe' }}
                    </span>
                    <h1 class="text-2xl font-extrabold text-white mt-1">{{ $vehicle->name }}</h1>
                    <p class="text-xs text-gray-400 mt-1"><i class="fa-solid fa-barcode mr-1"></i> Plat Nomor: {{ $vehicle->plate_number }}</p>
                </div>

                <div class="bg-[#030712] border border-gray-800 p-4 rounded-xl mb-6 flex items-center justify-between">
                    <div>
                        <span class="text-xs text-gray-400 block">Harga Sewa / Hari</span>
                        <span class="text-2xl font-black text-[#D97706]">Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}</span>
                        <span class="text-xs text-gray-500">/ 24 Jam</span>
                    </div>
                    <span class="text-xs bg-emerald-950 text-[#059669] border border-emerald-600/40 px-3 py-1 rounded-full font-bold">
                        <i class="fa-solid fa-shield-check mr-1"></i> Asuransi Siap
                    </span>
                </div>

                <h3 class="text-xs font-bold text-gray-300 uppercase tracking-wider mb-3">Spesifikasi Armada</h3>
                <div class="grid grid-cols-2 gap-3 mb-6 text-xs">
                    <div class="bg-[#030712] p-3 rounded-lg border border-gray-800 flex items-center gap-3">
                        <i class="fa-solid fa-calendar text-[#D97706] text-base"></i>
                        <div>
                            <p class="text-gray-400">Tahun</p>
                            <p class="font-bold text-white">{{ $vehicle->year }}</p>
                        </div>
                    </div>
                    <div class="bg-[#030712] p-3 rounded-lg border border-gray-800 flex items-center gap-3">
                        <i class="fa-solid fa-gears text-[#D97706] text-base"></i>
                        <div>
                            <p class="text-gray-400">Transmisi</p>
                            <p class="font-bold text-white">{{ ucfirst($vehicle->transmission) }}</p>
                        </div>
                    </div>
                    <div class="bg-[#030712] p-3 rounded-lg border border-gray-800 flex items-center gap-3">
                        <i class="fa-solid fa-gas-pump text-[#D97706] text-base"></i>
                        <div>
                            <p class="text-gray-400">Bahan Bakar</p>
                            <p class="font-bold text-white">{{ ucfirst($vehicle->fuel_type) }}</p>
                        </div>
                    </div>
                    <div class="bg-[#030712] p-3 rounded-lg border border-gray-800 flex items-center gap-3">
                        <i class="fa-solid fa-palette text-[#D97706] text-base"></i>
                        <div>
                            <p class="text-gray-400">Warna</p>
                            <p class="font-bold text-white">{{ $vehicle->color }}</p>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-xs font-bold text-gray-300 uppercase tracking-wider mb-2">Deskripsi</h3>
                    <p class="text-xs text-gray-400 leading-relaxed">{{ $vehicle->description ?? 'Tidak ada deskripsi khusus untuk armada ini.' }}</p>
                </div>

                @php
                    $statusValue = is_object($vehicle->status) ? $vehicle->status->value : $vehicle->status;
                @endphp

                @if($statusValue === 'available')
                    @auth
                        <a href="{{ route('customer.bookings.create', $vehicle->id) }}" class="w-full py-3 bg-[#D97706] text-slate-950 font-extrabold rounded-xl hover:bg-amber-500 transition shadow-lg shadow-amber-600/20 text-center block text-sm">
                            <i class="fa-solid fa-calendar-plus mr-1.5"></i> Booking Kendaraan Ini
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="w-full py-3 bg-[#D97706] text-slate-950 font-extrabold rounded-xl hover:bg-amber-500 transition shadow-lg shadow-amber-600/20 text-center block text-sm">
                            <i class="fa-solid fa-right-to-bracket mr-1.5"></i> Login Terlebih Dahulu untuk Booking
                        </a>
                    @endauth
                @else
                    <button disabled class="w-full py-3 bg-gray-800 text-gray-500 font-bold rounded-xl text-center text-sm cursor-not-allowed">
                        <i class="fa-solid fa-ban mr-1.5"></i> Armada Sedang Tidak Tersedia
                    </button>
                @endif

            </div>
        </div>
    </div>
</div>

<script>
    function changeImage(src) {
        document.getElementById('mainImage').src = src;
    }
</script>
@endsection