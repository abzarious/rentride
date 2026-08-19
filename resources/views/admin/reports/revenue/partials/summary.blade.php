<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pendapatan Hari Ini</p>
            <h3 class="text-xl font-black text-slate-800 mt-1">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</h3>
            <p class="text-[11px] text-emerald-600 font-semibold mt-0.5"><i class="fa-solid fa-calendar-day"></i> Real-time Hari Ini</p>
        </div>
        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-money-bill-wave"></i>
        </div>
    </div>

    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pendapatan Minggu Ini</p>
            <h3 class="text-xl font-black text-slate-800 mt-1">Rp {{ number_format($weekRevenue, 0, ',', '.') }}</h3>
            <p class="text-[11px] text-blue-600 font-semibold mt-0.5"><i class="fa-solid fa-calendar-week"></i> Pekan Berjalan</p>
        </div>
        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-chart-line"></i>
        </div>
    </div>

    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pendapatan Bulan Ini</p>
            <h3 class="text-xl font-black text-slate-800 mt-1">Rp {{ number_format($monthRevenue, 0, ',', '.') }}</h3>
            <p class="text-[11px] text-amber-600 font-semibold mt-0.5"><i class="fa-solid fa-calendar-days"></i> Bulan {{ date('F Y') }}</p>
        </div>
        <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-wallet"></i>
        </div>
    </div>

    <div class="bg-slate-900 text-white p-5 rounded-2xl shadow-sm flex items-center justify-between border border-slate-800">
        <div>
            <p class="text-[11px] font-bold text-amber-400 uppercase tracking-wider">Total Hasil Filter</p>
            <h3 class="text-xl font-black text-white mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            <p class="text-[11px] text-slate-400 font-medium mt-0.5"><i class="fa-solid fa-calculator"></i> Akumulasi Pilihan</p>
        </div>
        <div class="w-12 h-12 bg-amber-500/20 text-amber-400 border border-amber-500/30 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-coins"></i>
        </div>
    </div>

</div>