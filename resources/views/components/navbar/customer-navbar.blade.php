<header class="bg-[#111827]/90 backdrop-blur-md border-b border-gray-800 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
        <a href="/" class="flex items-center gap-2">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#D97706] to-amber-700 flex items-center justify-center text-slate-950 font-black text-xl shadow-lg shadow-amber-600/20">
                <i class="fa-solid fa-car"></i>
            </div>
            <span class="text-xl font-extrabold tracking-wider text-white">RENTAL<span class="text-[#D97706]">HUB</span></span>
        </a>

        <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-300">
            <a href="/" class="hover:text-[#D97706] transition-colors">Beranda</a>
            <a href="#" class="hover:text-[#D97706] transition-colors">Cari Armada</a>
            <a href="#" class="hover:text-[#D97706] transition-colors">Syarat & Ketentuan</a>
            <a href="#" class="hover:text-[#D97706] transition-colors">Kontak Kami</a>
        </nav>

        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('customer.dashboard') }}" class="px-4 py-2 text-xs font-semibold text-white bg-[#111827] border border-[#D97706] rounded-lg hover:bg-[#D97706] hover:text-slate-950 transition-all">
                    <i class="fa-solid fa-gauge mr-1.5 text-[#D97706]"></i> Dashboard
                </a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-xs font-semibold text-red-400 bg-red-950/40 border border-red-800/60 rounded-lg hover:bg-red-900 hover:text-white transition">
                        <i class="fa-solid fa-right-from-bracket mr-1"></i> Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-300 hover:text-white transition">Masuk</a>
                <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-semibold text-slate-950 bg-[#D97706] rounded-lg hover:bg-amber-500 transition shadow-lg shadow-amber-600/20">
                    Daftar
                </a>
            @endauth
        </div>
    </div>
</header>