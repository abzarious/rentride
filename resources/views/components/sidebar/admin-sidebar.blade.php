<aside class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between hidden md:flex shrink-0">
    <div>
        <div class="h-16 flex items-center px-6 bg-slate-950 font-bold text-xl text-white tracking-wider border-b border-slate-800">
            <i class="fa-solid fa-car-side text-amber-500 mr-3"></i> RENTAL<span class="text-amber-500">HUB</span>
        </div>

        <nav class="p-4 space-y-1 text-sm font-medium">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-white bg-amber-600 font-semibold transition">
                <i class="fa-solid fa-chart-line w-6"></i> Dashboard
            </a>
            
            <div class="pt-4 pb-1 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Master Data</div>
            <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition">
                <i class="fa-solid fa-car w-6"></i> Kendaraan
            </a>
            <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition">
                <i class="fa-solid fa-layer-group w-6"></i> Kategori & Brand
            </a>
            <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition">
                <i class="fa-solid fa-users w-6"></i> Manajemen User
            </a>

            <div class="pt-4 pb-1 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Transaksi</div>
            <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition">
                <i class="fa-solid fa-calendar-check w-6"></i> Data Booking
            </a>
            <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition">
                <i class="fa-solid fa-file-invoice-dollar w-6"></i> Pembayaran
            </a>

            <div class="pt-4 pb-1 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Laporan</div>
            <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition">
                <i class="fa-solid fa-chart-pie w-6"></i> Laporan Keuangan
            </a>
            <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition">
                <i class="fa-solid fa-gear w-6"></i> Pengaturan
            </a>
        </nav>
    </div>

    <div class="p-4 border-t border-slate-800">
        <div class="flex items-center justify-between text-sm">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-amber-500 text-slate-900 font-bold flex items-center justify-center">
                    {{ strtoupper(substr(auth()->user()->name ?? 'AD', 0, 2)) }}
                </div>
                <div class="truncate max-w-[110px]">
                    <p class="font-semibold text-white text-xs truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-[10px] text-slate-400 truncate">{{ auth()->user()->email ?? 'admin@gmail.com' }}</p>
                </div>
            </div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Logout" class="text-slate-400 hover:text-red-400 p-2 rounded-lg hover:bg-slate-800 transition">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </div>
</aside>