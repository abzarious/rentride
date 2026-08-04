@extends('layouts.customer')

@section('title', 'Edit Profil & Password - RentRide')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10 space-y-8">
    
    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-8 shadow-xl">
        <h2 class="text-xl font-bold text-white mb-6 border-b border-gray-800 pb-4">
            <i class="fa-solid fa-user-pen text-[#D97706] mr-2"></i> Edit Profil Pengguna
        </h2>

        @if($errors->any())
            <x-alerts.alert type="danger" class="mb-6">
                <ul class="list-disc pl-4 text-xs space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alerts.alert>
        @endif

        <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="flex items-center gap-6 p-4 bg-[#030712] rounded-xl border border-gray-800">
                <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-[#D97706] bg-gray-900 shrink-0">
                    @if($user->profile->photo ?? false)
                        <img src="{{ asset('storage/' . $user->profile->photo) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-500 font-bold text-lg">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    @endif
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-300 uppercase mb-1">Unggah Foto Profil</label>
                    <input type="file" name="photo" accept="image/*" class="text-xs text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#D97706] file:text-slate-950 hover:file:bg-amber-500">
                    <p class="text-[10px] text-gray-500 mt-1">Format: JPG, PNG, Max 2MB</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-300 uppercase mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 bg-[#030712] border border-gray-800 rounded-xl text-white text-sm focus:border-[#D97706] focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-300 uppercase mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2.5 bg-[#030712] border border-gray-800 rounded-xl text-white text-sm focus:border-[#D97706] focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-300 uppercase mb-2">No. WA / HP</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone ?? $user->profile->phone ?? '') }}" class="w-full px-4 py-2.5 bg-[#030712] border border-gray-800 rounded-xl text-white text-sm focus:border-[#D97706] focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-300 uppercase mb-2">NIK KTP</label>
                    <input type="text" name="nik" value="{{ old('nik', $user->profile->nik ?? '') }}" class="w-full px-4 py-2.5 bg-[#030712] border border-gray-800 rounded-xl text-white text-sm focus:border-[#D97706] focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-300 uppercase mb-2">No. SIM A/C</label>
                    <input type="text" name="sim_number" value="{{ old('sim_number', $user->profile->sim_number ?? '') }}" class="w-full px-4 py-2.5 bg-[#030712] border border-gray-800 rounded-xl text-white text-sm focus:border-[#D97706] focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-300 uppercase mb-2">Alamat Domisili</label>
                <textarea name="address" rows="3" class="w-full px-4 py-2.5 bg-[#030712] border border-gray-800 rounded-xl text-white text-sm focus:border-[#D97706] focus:outline-none">{{ old('address', $user->profile->address ?? '') }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('customer.profile.index') }}" class="px-5 py-2.5 bg-gray-800 text-gray-300 rounded-xl text-xs font-semibold hover:bg-gray-700">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-[#D97706] text-slate-950 font-extrabold rounded-xl text-xs hover:bg-amber-500">Simpan Perubahan Profil</button>
            </div>
        </form>
    </div>

    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-8 shadow-xl">
        <h2 class="text-xl font-bold text-white mb-6 border-b border-gray-800 pb-4">
            <i class="fa-solid fa-key text-[#D97706] mr-2"></i> Perbarui Password Akun
        </h2>

        <form action="{{ route('customer.profile.password') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-semibold text-gray-300 uppercase mb-2">Password Saat Ini</label>
                <input type="password" name="current_password" required class="w-full px-4 py-2.5 bg-[#030712] border border-gray-800 rounded-xl text-white text-sm focus:border-[#D97706] focus:outline-none">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-300 uppercase mb-2">Password Baru (Min 8 Karakter)</label>
                    <input type="password" name="password" required class="w-full px-4 py-2.5 bg-[#030712] border border-gray-800 rounded-xl text-white text-sm focus:border-[#D97706] focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-300 uppercase mb-2">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" required class="w-full px-4 py-2.5 bg-[#030712] border border-gray-800 rounded-xl text-white text-sm focus:border-[#D97706] focus:outline-none">
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-6 py-2.5 bg-red-600 text-white font-extrabold rounded-xl text-xs hover:bg-red-700">
                    <i class="fa-solid fa-lock mr-1"></i> Update Password
                </button>
            </div>
        </form>
    </div>

</div>
@endsection