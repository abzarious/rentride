@extends('layouts.admin')

@section('title', 'Tambah Brand - RentRide')
@section('page_title', 'Tambah Brand Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <div class="mb-6 pb-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-800">Form Tambah Brand</h3>
                <p class="text-xs text-slate-500 mt-1">Isi nama merk/pabrikan kendaraan yang ingin ditambahkan.</p>
            </div>
            <a href="{{ route('admin.brands.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.brands.store') }}" method="POST">
            @include('admin.brand._form')
        </form>
    </div>
</div>
@endsection