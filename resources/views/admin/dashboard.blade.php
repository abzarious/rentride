@extends('layouts.admin')

@section('title', 'Admin Dashboard - RentRide')
@section('page_title', 'Dashboard Utama Admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="mb-6 bg-slate-900 text-white p-6 rounded-2xl shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
        <p class="text-xs text-slate-400 mt-1">Ringkasan kondisi dan statistik operasional RentRide secara real-time.</p>
    </div>
    <div class="flex items-center gap-3">
        <span class="px-3 py-1 bg-amber-500/20 border border-amber-500 text-amber-400 text-xs font-bold rounded-full uppercase">
            Role: {{ auth()->user()->role }}
        </span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition flex items-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Kendaraan</p>
            <h3 class="text-2xl font-black text-slate-800 mt-1">{{ number_format($total_kendaraan) }} Unit</h3>
            <div class="flex items-center gap-2 mt-1.5 text-xs text-slate-500 font-medium">
                <span class="text-blue-600 font-semibold"><i class="fa-solid fa-car"></i> {{ $total_mobil }} Mobil</span>
                <span>•</span>
                <span class="text-amber-600 font-semibold"><i class="fa-solid fa-motorcycle"></i> {{ $total_motor }} Motor</span>
            </div>
        </div>
        <div class="w-12 h-12 bg-slate-100 text-slate-700 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-layer-group"></i>
        </div>
    </div>

    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Siap Sewa (Available)</p>
            <h3 class="text-2xl font-black text-emerald-600 mt-1">{{ number_format($total_available) }} Unit</h3>
            <p class="text-xs text-emerald-600/80 font-medium mt-1"><i class="fa-solid fa-circle-check"></i> Siap Bertransaksi</p>
        </div>
        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-car-side"></i>
        </div>
    </div>

    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Dipesan (Booked)</p>
            <h3 class="text-2xl font-black text-amber-600 mt-1">{{ number_format($total_booked) }} Unit</h3>
            <p class="text-xs text-amber-600/80 font-medium mt-1"><i class="fa-solid fa-clock"></i> Menunggu Diambil</p>
        </div>
        <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-calendar-check"></i>
        </div>
    </div>

    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Sedang Dirental</p>
            <h3 class="text-2xl font-black text-blue-600 mt-1">{{ number_format($total_rented) }} Unit</h3>
            <p class="text-xs text-blue-600/80 font-medium mt-1"><i class="fa-solid fa-key"></i> Di Tangan Penyewa</p>
        </div>
        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-[#059669] fa-road"></i>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Perbaikan (Maintenance)</p>
            <h3 class="text-2xl font-black text-purple-600 mt-1">{{ number_format($total_maintenance) }} Unit</h3>
            <p class="text-xs text-purple-600/80 font-medium mt-1"><i class="fa-solid fa-wrench"></i> Tidak Ditampilkan</p>
        </div>
        <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-screwdriver-wrench"></i>
        </div>
    </div>

    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Customer</p>
            <h3 class="text-2xl font-black text-slate-800 mt-1">{{ number_format($total_customer) }} Akun</h3>
            <p class="text-xs text-slate-500 font-medium mt-1"><i class="fa-solid fa-users"></i> Terdaftar di Sistem</p>
        </div>
        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-user-group"></i>
        </div>
    </div>

    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Pendapatan</p>
            <h3 class="text-xl font-black text-slate-800 mt-1">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</h3>
            <p class="text-xs text-emerald-600 font-medium mt-1"><i class="fa-solid fa-circle-dollar-to-slot"></i> Transaksi Selesai</p>
        </div>
        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-wallet"></i>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-chart-pie text-amber-500"></i> Distribusi Status Kendaraan
        </h3>
        <div class="relative h-56 flex items-center justify-center">
            <canvas id="statusChart"></canvas>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm lg:col-span-2">
        <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-chart-column text-blue-500"></i> Komposisi Jenis Armada (Mobil vs Motor)
        </h3>
        <div class="relative h-56">
            <canvas id="categoryChart"></canvas>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-amber-500"></i> Terbaru Ditambahkan
            </h3>
            <a href="{{ route('admin.vehicles.index') }}" class="text-xs text-amber-600 font-semibold hover:underline">Lihat Semua</a>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($latest_vehicles as $vehicle)
                <div class="py-3 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-800">{{ $vehicle->name }}</p>
                        <p class="text-[10px] text-slate-400">{{ $vehicle->brand->name ?? '-' }} • {{ $vehicle->plate_number }}</p>
                    </div>
                    <x-badges.status-badge :status="$vehicle->status" />
                </div>
            @empty
                <p class="text-xs text-slate-400 py-4 text-center">Belum ada data kendaraan.</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-500"></i> Siap Disewakan
            </h3>
            <span class="text-xs bg-emerald-100 text-emerald-700 px-2.5 py-0.5 rounded-full font-bold">{{ $total_available }}</span>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($available_vehicles as $vehicle)
                <div class="py-3 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-800">{{ $vehicle->name }}</p>
                        <p class="text-[10px] text-slate-500">Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }} / hari</p>
                    </div>
                    <span class="text-[11px] font-semibold text-slate-600 bg-slate-100 px-2 py-0.5 rounded">{{ $vehicle->plate_number }}</span>
                </div>
            @empty
                <p class="text-xs text-slate-400 py-4 text-center">Tidak ada kendaraan siap sewa.</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-screwdriver-wrench text-purple-500"></i> Sedang Service / Perbaikan
            </h3>
            <span class="text-xs bg-purple-100 text-purple-700 px-2.5 py-0.5 rounded-full font-bold">{{ $total_maintenance }}</span>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($maintenance_vehicles as $vehicle)
                <div class="py-3 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-800">{{ $vehicle->name }}</p>
                        <p class="text-[10px] text-purple-600 font-medium">Status: Dalam Perbaikan</p>
                    </div>
                    <span class="text-[11px] font-semibold text-slate-600 bg-slate-100 px-2 py-0.5 rounded">{{ $vehicle->plate_number }}</span>
                </div>
            @empty
                <p class="text-xs text-slate-400 py-4 text-center">Tidak ada armada di bengkel.</p>
            @endforelse
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // 1. Chart Donut Status Kendaraan
        const ctxStatus = document.getElementById('statusChart').getContext('2d');
        new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: ['Available', 'Booked', 'Rented', 'Maintenance', 'Inactive'],
                datasets: [{
                    data: [
                        {{ $total_available }},
                        {{ $total_booked }},
                        {{ $total_rented }},
                        {{ $total_maintenance }},
                        {{ $total_inactive }}
                    ],
                    backgroundColor: ['#10B981', '#F59E0B', '#3B82F6', '#8B5CF6', '#6B7280'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 12, font: { size: 11 } }
                    }
                }
            }
        });

        // 2. Chart Bar Kategori Kendaraan
        const ctxCategory = document.getElementById('categoryChart').getContext('2d');
        new Chart(ctxCategory, {
            type: 'bar',
            data: {
                labels: ['Mobil', 'Motor'],
                datasets: [{
                    label: 'Jumlah Unit',
                    data: [{{ $total_mobil }}, {{ $total_motor }}],
                    backgroundColor: ['#3B82F6', '#D97706'],
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });
    });
</script>
@endsection