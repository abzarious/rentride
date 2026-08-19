<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-slate-200 flex items-center justify-between">
        <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
            <i class="fa-solid fa-receipt text-amber-500"></i> Rincian Transaksi Pemasukan
        </h3>
        <span class="text-xs font-semibold text-slate-500">Menampilkan {{ $payments->count() }} dari {{ $payments->total() }} Data</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-slate-700">
            <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] border-b border-slate-200">
                <tr>
                    <th class="p-4">NO</th>
                    <th class="p-4">INVOICE</th>
                    <th class="p-4">CUSTOMER</th>
                    <th class="p-4">KENDARAAN</th>
                    <th class="p-4">TANGGAL PEMBAYARAN</th>
                    <th class="p-4">NOMINAL</th>
                    <th class="p-4">STATUS</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($payments as $payment)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-4 font-bold text-slate-400">
                            {{ $payments->firstItem() + $loop->index }}
                        </td>
                        <td class="p-4 font-bold text-amber-600">
                            {{ $payment->booking->invoice_number ?? '-' }}
                        </td>
                        <td class="p-4">
                            <p class="font-bold text-slate-800">{{ $payment->booking->user->name ?? '-' }}</p>
                            <p class="text-[10px] text-slate-400">{{ $payment->booking->user->email ?? '-' }}</p>
                        </td>
                        <td class="p-4">
                            <p class="font-bold text-slate-800">{{ $payment->booking->vehicle->name ?? '-' }}</p>
                            <span class="font-mono text-[10px] text-slate-500 bg-slate-100 px-1.5 py-0.5 rounded border">{{ $payment->booking->vehicle->plate_number ?? '-' }}</span>
                        </td>
                        <td class="p-4 font-mono text-slate-600">
                            {{ $payment->created_at->format('d M Y, H:i') }} WIB
                        </td>
                        <td class="p-4 font-black text-emerald-600 text-sm">
                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 rounded-full text-[10px] font-extrabold uppercase">
                                <i class="fa-solid fa-circle-check mr-1"></i> Terverifikasi
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-slate-400">
                            <i class="fa-solid fa-folder-open text-3xl mb-2 text-slate-300 block"></i>
                            Tidak ada transaksi pendapatan pada periode/filter ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($payments->hasPages())
        <div class="p-4 border-t border-slate-200 bg-slate-50">{{ $payments->links() }}</div>
    @endif
</div>