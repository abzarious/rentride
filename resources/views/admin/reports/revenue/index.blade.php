@extends('layouts.admin')

@section('title', 'Laporan Pendapatan - RentRide Admin')
@section('page_title', 'Laporan Pendapatan Rental')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Laporan Pendapatan Operasional</h1>
            <p class="text-xs text-slate-500 mt-1">Rekapitulasi pemasukan dari transaksi pembayaran sewa kendaraan yang terverifikasi.</p>
        </div>
    </div>

    @include('admin.reports.revenue.partials.filters')

    @include('admin.reports.revenue.partials.summary')

    @include('admin.reports.revenue.partials.table')

</div>
@endsection