<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-extrabold text-white tracking-wide">Selamat Datang Kembali</h2>
        <p class="text-xs text-gray-400 mt-1">Masukkan kredensial akun Anda untuk masuk ke RentalHub</p>
    </div>

    <x-auth-session-status class="mb-4 text-emerald-400 text-xs font-medium" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-xs font-bold text-gray-300 uppercase tracking-wider mb-1.5">Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-500">
                    <i class="fa-regular fa-envelope"></i>
                </div>
                <input id="email" 
                       type="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       placeholder="nama@email.com" 
                       required autofocus autocomplete="username"
                       class="w-full pl-10 pr-4 py-2.5 bg-[#030712] border border-gray-800 text-white text-sm rounded-xl focus:border-[#D97706] focus:ring-1 focus:ring-[#D97706] focus:outline-none transition">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-red-400 text-xs" />
        </div>

        <div>
            <label for="password" class="block text-xs font-bold text-gray-300 uppercase tracking-wider mb-1.5">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-500">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <input id="password" 
                       type="password" 
                       name="password" 
                       placeholder="••••••••" 
                       required autocomplete="current-password"
                       class="w-full pl-10 pr-4 py-2.5 bg-[#030712] border border-gray-800 text-white text-sm rounded-xl focus:border-[#D97706] focus:ring-1 focus:ring-[#D97706] focus:outline-none transition">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-red-400 text-xs" />
        </div>

        <div class="flex items-center justify-between text-xs pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-800 bg-[#030712] text-[#D97706] focus:ring-[#D97706]">
                <span class="ms-2 text-gray-400 hover:text-gray-200">Ingat Saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-[#D97706] hover:underline font-semibold" href="{{ route('password.request') }}">
                    Lupa Password?
                </a>
            @endif
        </div>

        <div class="pt-3">
            <button type="submit" class="w-full py-3 bg-[#D97706] hover:bg-amber-500 active:bg-amber-600 text-slate-950 font-extrabold rounded-xl text-sm tracking-wider uppercase transition shadow-lg shadow-amber-600/20 flex items-center justify-center gap-2">
                <i class="fa-solid fa-right-to-bracket"></i> Masuk Sekarang
            </button>
        </div>

        @if (Route::has('register'))
            <p class="text-center text-xs text-gray-400 pt-4 border-t border-gray-800/80 mt-4">
                Belum memiliki akun? 
                <a href="{{ route('register') }}" class="text-[#D97706] font-bold hover:underline ml-1">Daftar Akun Baru</a>
            </p>
        @endif
    </form>
</x-guest-layout>