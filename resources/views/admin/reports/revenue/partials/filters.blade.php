<div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
    <form method="GET" action="{{ route('admin.reports.revenue') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        <div>
            <label for="start_date" class="block text-xs font-bold text-slate-700 uppercase mb-1">Tanggal Mulai</label>
            <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none">
        </div>

        <div>
            <label for="end_date" class="block text-xs font-bold text-slate-700 uppercase mb-1">Tanggal Selesai</label>
            <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none">
        </div>

        <div>
            <label for="month" class="block text-xs font-bold text-slate-700 uppercase mb-1">Bulan</label>
            <select id="month" name="month" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none">
                <option value="">Semua Bulan</option>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" @selected((int) request('month') === $i)>
                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>
        </div>

        <div>
            <label for="year" class="block text-xs font-bold text-slate-700 uppercase mb-1">Tahun</label>
            <input type="number" id="year" name="year" value="{{ request('year', date('Y')) }}" min="2020" max="2100" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none">
        </div>

        <div class="sm:col-span-2 lg:col-span-4 flex items-center justify-between gap-2 pt-2 border-t border-slate-100">
            <div class="flex items-center gap-2">
                <button type="submit" class="px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs rounded-xl transition flex items-center gap-1.5 shadow-sm">
                    <i class="fa-solid fa-filter"></i> Terapkan Filter
                </button>
                <a href="{{ route('admin.reports.revenue') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
                    Reset
                </a>
            </div>

            <a href="{{ route('admin.reports.revenue.pdf', request()->all()) }}" target="_blank" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold text-xs rounded-xl transition flex items-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-file-pdf"></i> Cetak PDF Laporan
            </a>
        </div>

    </form>
</div>