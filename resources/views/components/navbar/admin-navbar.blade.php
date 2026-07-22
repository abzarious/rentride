<header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 sticky top-0 z-10">
    <div class="flex items-center gap-4">
        <button class="md:hidden text-slate-600 focus:outline-none">
            <i class="fa-solid fa-bars text-xl"></i>
        </button>
        <h2 class="text-lg font-bold text-slate-800">@yield('page_title', 'Dashboard')</h2>
    </div>

    <div class="flex items-center gap-4">
        <span class="text-xs bg-slate-100 border border-slate-300 text-slate-600 px-3 py-1 rounded-full font-medium hidden sm:inline-block">
            <i class="fa-regular fa-calendar mr-1"></i> {{ date('d M Y') }}
        </span>

        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-600 border border-red-200 text-xs font-semibold rounded-lg hover:bg-red-600 hover:text-white transition flex items-center gap-1.5">
                <i class="fa-solid fa-power-off"></i> Logout
            </button>
        </form>
    </div>
</header>