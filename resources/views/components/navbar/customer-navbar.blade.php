<header class="bg-[#111827]/90 backdrop-blur-md border-b border-gray-800 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
        <a href="/" class="flex items-center gap-3">
            @if($setting->logo ?? false)
                <img src="{{ asset('storage/' . $setting->logo) }}" class="w-10 h-10 object-contain">
            @else
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#D97706] to-amber-700 flex items-center justify-center text-slate-950 font-black text-xl shadow-lg shadow-amber-600/20">
                    <i class="fa-solid fa-car"></i>
                </div>
            @endif
            <span class="text-xl font-extrabold tracking-wider text-white">
                {{ strtoupper($setting->company_name ?? 'RentRide') }}
            </span>
        </a>

        @auth
        <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-300">
            <a href="{{ route('customer.dashboard') }}" class="{{ request()->routeIs('customer.dashboard') ? 'text-[#D97706] font-bold' : 'hover:text-[#D97706]' }} transition-colors">Dashboard</a>
            <a href="{{ route('customer.bookings.index') }}" class="{{ request()->routeIs('customer.bookings.index') ? 'text-[#D97706] font-bold' : 'hover:text-[#D97706]' }} transition-colors">Booking Saya</a>
            <a href="{{ route('customer.bookings.history') }}" class="{{ request()->routeIs('customer.bookings.history') ? 'text-[#D97706] font-bold' : 'hover:text-[#D97706]' }} transition-colors">Riwayat Rental</a>
            <a href="{{ route('customer.profile.index') }}" class="{{ request()->routeIs('customer.profile.*') ? 'text-[#D97706] font-bold' : 'hover:text-[#D97706]' }} transition-colors">Profil Saya</a>
        </nav>
        @endauth

        <div class="flex items-center gap-3">
            @auth
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