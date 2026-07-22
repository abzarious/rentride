@extends('layouts.customer')

@section('title', 'Profil Saya - RentRide')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-8 shadow-xl">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-800">
            <div>
                <h2 class="text-2xl font-bold text-white">Profil Pengguna</h2>
                <p class="text-xs text-gray-400">Detail akun persewaan Anda di RentalHub</p>
            </div>
            <a href="{{ route('customer.profile.edit') }}" class="px-4 py-2 bg-[#D97706] text-slate-950 font-bold rounded-lg hover:bg-amber-500 text-sm transition">
                <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Profil
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-950 border border-emerald-600 text-[#059669] rounded-xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-4 text-sm">
            <div class="grid grid-cols-1 sm:grid-cols-3 p-3 bg-[#030712] rounded-lg border border-gray-800">
                <span class="text-gray-400 font-medium">Nama Lengkap</span>
                <span class="sm:col-span-2 text-white font-semibold">{{ $user->name }}</span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 p-3 bg-[#030712] rounded-lg border border-gray-800">
                <span class="text-gray-400 font-medium">Alamat Email</span>
                <span class="sm:col-span-2 text-white font-semibold">{{ $user->email }}</span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 p-3 bg-[#030712] rounded-lg border border-gray-800">
                <span class="text-gray-400 font-medium">Nomor WhatsApp / HP</span>
                <span class="sm:col-span-2 text-white font-semibold">{{ $user->phone ?? 'Belum Diisi' }}</span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 p-3 bg-[#030712] rounded-lg border border-gray-800">
                <span class="text-gray-400 font-medium">Role Akun</span>
                <span class="sm:col-span-2 text-[#D97706] font-bold uppercase">{{ $user->role }}</span>
            </div>
        </div>
    </div>
</div>
@endsection