@extends('layouts.customer')

@section('title', 'Booking Aktif Saya - RentRide')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <span class="text-xs font-bold text-[#D97706] uppercase tracking-widest">Aktivitas Rental</span>
            <h1 class="text-2xl font-black text-white mt-0.5">Booking Aktif Saya</h1>
            <p class="text-xs text-gray-400 mt-1">Daftar transaksi rental yang sedang menunggu konfirmasi atau sedang berlangsung.</p>
        </div>
        <a href="{{ url('/#katalog') }}" class="px-4 py-2.5 bg-[#D97706] text-slate-950 font-bold rounded-xl hover:bg-amber-500 text-xs transition flex items-center gap-2 shadow-lg shadow-amber-600/20 w-fit">
            <i class="fa-solid fa-plus"></i> Tambah Booking Baru
        </a>
    </div>

    @if(session('success'))
        <x-alerts.alert type="success" class="mb-6">
            {{ session('success') }}
        </x-alerts.alert>
    @endif

    @if($bookings->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($bookings as $b)
                <div class="bg-[#111827] border border-gray-800 rounded-2xl overflow-hidden shadow-xl hover:border-[#D97706]/40 transition duration-300 flex flex-col justify-between">
                    <div>
                        <div class="p-5 border-b border-gray-800/80 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] font-bold text-gray-500 uppercase block">Invoice</span>
                                <span class="text-sm font-extrabold text-[#D97706]">{{ $b->invoice_number }}</span>
                            </div>
                            <x-badges.status-badge :status="$b->status" />
                        </div>

                        <div class="p-5 space-y-4">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-xl bg-gray-900 border border-gray-800 overflow-hidden shrink-0">
                                    @if($b->vehicle->thumbnail)
                                        <img src="{{ asset('storage/' . $b->vehicle->thumbnail) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-700">
                                            <i class="fa-solid fa-car text-xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <span class="text-[10px] text-gray-400 uppercase font-bold">{{ $b->vehicle->brand->name ?? '' }}</span>
                                    <h3 class="text-sm font-bold text-white">{{ $b->vehicle->name }}</h3>
                                    <p class="text-[11px] text-gray-400 mt-0.5"><i class="fa-solid fa-barcode mr-1"></i> Plat: {{ $b->vehicle->plate_number }}</p>
                                </div>
                            </div>

                            <div class="bg-[#030712] p-3 rounded-xl border border-gray-800 space-y-1.5 text-xs text-gray-300">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Mulai:</span>
                                    <span class="font-semibold text-white">{{ $b->start_date->format('d M Y H:i') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Selesai:</span>
                                    <span class="font-semibold text-white">{{ $b->end_date->format('d M Y H:i') }}</span>
                                </div>
                                <div class="flex justify-between pt-1 border-t border-gray-800 text-gray-400">
                                    <span>Durasi:</span>
                                    <span class="font-bold text-[#D97706]">{{ $b->duration_days }} Hari</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 pt-0 flex items-center justify-between gap-3">
                        <div>
                            <span class="text-[10px] text-gray-500 block">Total Biaya</span>
                            <span class="text-sm font-black text-white">Rp {{ number_format($b->total_price, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('customer.bookings.show', $b->id) }}" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white font-bold rounded-xl text-xs transition border border-gray-700">
                            Detail & WA <i class="fa-solid fa-chevron-right ml-1 text-[10px]"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $bookings->links() }}
        </div>
    @else
        <div class="bg-[#111827] border border-gray-800 rounded-2xl p-12 text-center max-w-lg mx-auto my-12">
            <div class="w-16 h-16 bg-amber-500/10 text-[#D97706] border border-amber-500/20 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4">
                <i class="fa-solid fa-calendar-xmark"></i>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">Tidak Ada Booking Aktif</h3>
            <p class="text-xs text-gray-400 mb-6 leading-relaxed">Saat ini Anda tidak memiliki transaksi rental yang sedang berjalan atau menunggu verifikasi.</p>
            <a href="{{ url('/#katalog') }}" class="px-6 py-3 bg-[#D97706] text-slate-950 font-extrabold rounded-xl hover:bg-amber-500 text-xs transition inline-flex items-center gap-2 shadow-lg shadow-amber-600/20">
                <i class="fa-solid fa-car"></i> Cari & Sewa Armada Sekarang
            </a>
        </div>
    @endif

</div>
@endsection