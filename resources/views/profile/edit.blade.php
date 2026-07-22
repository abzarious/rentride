{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

@extends('layouts.customer')

@section('title', 'Edit Profil - RentRide')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">
    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-8 shadow-xl">
        <h2 class="text-2xl font-bold text-white mb-6 border-b border-gray-800 pb-4">Edit Profil Pengguna</h2>

        <form action="{{ route('customer.profile.update') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-semibold text-gray-300 uppercase mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 bg-[#030712] border border-gray-800 rounded-lg text-white text-sm focus:border-[#D97706] focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-300 uppercase mb-2">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2.5 bg-[#030712] border border-gray-800 rounded-lg text-white text-sm focus:border-[#D97706] focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-300 uppercase mb-2">Nomor Telepon / WA</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="081234567890" class="w-full px-4 py-2.5 bg-[#030712] border border-gray-800 rounded-lg text-white text-sm focus:border-[#D97706] focus:outline-none">
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('customer.profile.index') }}" class="px-4 py-2 bg-gray-800 text-gray-300 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">Batal</a>
                <button type="submit" class="px-5 py-2 bg-[#D97706] text-slate-950 font-bold rounded-lg text-sm hover:bg-amber-500 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection