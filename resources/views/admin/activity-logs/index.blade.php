@extends('layouts.admin')

@section('title', 'Activity Logs - RentRide')
@section('page_title', 'Catatan Aktivitas Sistem (Activity Log)')

@section('content')
<div class="space-y-6">

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-list-check text-amber-500"></i> Audit Trail Aktivitas Admin & Sistem
        </h3>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] border-b border-slate-200">
                    <tr>
                        <th class="p-3">WAKTU</th>
                        <th class="p-3">ADMIN / USER</th>
                        <th class="p-3">AKSI</th>
                        <th class="p-3">DESKRIPSI</th>
                        <th class="p-3">IP ADDRESS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="p-3 text-slate-400 font-mono text-[11px]">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                            <td class="p-3 font-bold text-slate-800">{{ $log->user->name ?? 'Sistem' }}</td>
                            <td class="p-3">
                                <span class="px-2 py-0.5 bg-amber-100 text-amber-700 border border-amber-200 rounded text-[10px] font-bold uppercase">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="p-3 font-medium text-slate-800">{{ $log->description }}</td>
                            <td class="p-3 text-slate-400 font-mono">{{ $log->ip_address ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-slate-400">Belum ada aktivitas yang tercatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $logs->links() }}</div>
    </div>

</div>
@endsection