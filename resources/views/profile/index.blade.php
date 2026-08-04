@extends('layouts.customer')

@section('title', 'Profil Saya - RentRide')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-8 shadow-xl">
        
        <div class="flex flex-col sm:flex-row items-center justify-between gap-6 mb-8 pb-6 border-b border-gray-800">
            <div class="flex items-center gap-5">
                <div class="w-20 h-20 rounded-full overflow-hidden border-2 border-[#D97706] bg-gray-900 shrink-0">
                    @if($user->profile->photo ?? false)
                        <img src="{{ asset('storage/' . $user->profile->photo) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-[#D97706] font-bold text-2xl">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    @endif
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white">{{ $user->name }}</h2>
                    <p class="text-xs text-gray-400 mt-1"><i class="fa-regular fa-envelope mr-1"></i> {{ $user->email }}</p>
                    <span class="inline-block mt-2 px-3 py-0.5 bg-amber-500/10 border border-amber-500/30 text-[#D97706] font-bold text-[10px] rounded-full uppercase">
                        Role: {{ $user->role }}
                    </span>
                </div>
            </div>
            
            <a href="{{ route('customer.profile.edit') }}" class="px-5 py-2.5 bg-[#D97706] text-slate-950 font-extrabold rounded-xl hover:bg-amber-500 text-xs transition flex items-center gap-2 shadow-lg shadow-amber-600/20">
                <i class="fa-solid fa-pen-to-square"></i> Edit Profil & Password
            </a>
        </div>

        @if(session('success'))
            <x-alerts.alert type="success" class="mb-6">
                {{ session('success') }}
            </x-alerts.alert>
        @endif

        <div class="space-y-4 text-sm">
            <div class="grid grid-cols-1 sm:grid-cols-3 p-4 bg-[#030712] rounded-xl border border-gray-800">
                <span class="text-gray-400 font-medium">Nama Lengkap</span>
                <span class="sm:col-span-2 text-white font-semibold">{{ $user->name }}</span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 p-4 bg-[#030712] rounded-xl border border-gray-800">
                <span class="text-gray-400 font-medium">Alamat Email</span>
                <span class="sm:col-span-2 text-white font-semibold">{{ $user->email }}</span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 p-4 bg-[#030712] rounded-xl border border-gray-800">
                <span class="text-gray-400 font-medium">No. Telepon / WhatsApp</span>
                <span class="sm:col-span-2 text-white font-semibold">{{ $user->phone ?? $user->profile->phone ?? 'Belum Diisi' }}</span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 p-4 bg-[#030712] rounded-xl border border-gray-800">
                <span class="text-gray-400 font-medium">NIK (KTP)</span>
                <span class="sm:col-span-2 text-white font-semibold">{{ $user->profile->nik ?? 'Belum Diisi' }}</span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 p-4 bg-[#030712] rounded-xl border border-gray-800">
                <span class="text-gray-400 font-medium">Nomor SIM A / C</span>
                <span class="sm:col-span-2 text-white font-semibold">{{ $user->profile->sim_number ?? 'Belum Diisi' }}</span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 p-4 bg-[#030712] rounded-xl border border-gray-800">
                <span class="text-gray-400 font-medium">Alamat Domisili</span>
                <span class="sm:col-span-2 text-white font-semibold leading-relaxed">{{ $user->profile->address ?? 'Belum Diisi' }}</span>
            </div>
        </div>

    </div>
</div>
@endsection