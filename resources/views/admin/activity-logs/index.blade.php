@extends('layouts.admin')

@section('title', 'Activity Log - RentRide Admin')
@section('page_title', 'Riwayat Aktivitas Sistem (Activity Log)')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Activity Log</h1>
            <p class="text-xs text-slate-500 mt-1">Audit trail seluruh jejak aktivitas pengguna dan transaksi admin RentRide.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] border-b border-slate-200">
                    <tr>
                        <th class="p-4">WAKTU</th>
                        <th class="p-4">USER / ADMIN</th>
                        <th class="p-4">AKSI</th>
                        <th class="p-4">DESKRIPSI RINGKAS</th>
                        <th class="p-4">IP ADDRESS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-mono text-slate-500 text-[11px]">
                                {{ $log->created_at->format('d M Y, H:i:s') }}
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-amber-500 text-slate-900 font-bold flex items-center justify-center text-[10px]">
                                        {{ strtoupper(substr($log->user->name ?? 'SY', 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800">{{ $log->user->name ?? 'System' }}</p>
                                        <p class="text-[10px] text-slate-400 capitalize">{{ $log->user->role ?? 'System' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-800 border border-slate-300 rounded-full text-[10px] font-bold font-mono uppercase">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="p-4 text-slate-700 leading-relaxed max-w-xs">
                                {{ $log->description }}
                            </td>
                            <td class="p-4 font-mono text-[10px] text-slate-400">
                                {{ $log->ip_address ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400">
                                <i class="fa-solid fa-clock-rotate-left text-3xl mb-2 text-slate-300 block"></i>
                                Belum ada riwayat aktivitas tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50">{{ $logs->links() }}</div>
        @endif
    </div>

</div>
@endsection