@extends('layouts.admin')

@section('title', 'Tambah Kategori - RentRide Admin')
@section('page_title', 'Tambah Kategori Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.vehicle-categories.index') }}" class="text-xs text-amber-600 hover:underline flex items-center gap-1">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke daftar kategori
        </a>
        <h1 class="text-2xl font-bold text-slate-800 mt-2">Tambah Kategori Kendaraan</h1>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <form action="{{ route('admin.vehicle-categories.store') }}" method="POST">
            @include('admin.vehicle-categories.form')
        </form>
    </div>
</div>
@endsection