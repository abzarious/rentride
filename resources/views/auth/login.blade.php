<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="inline-flex w-12 h-12 rounded-xl bg-gradient-to-br from-[#D97706] to-amber-700 items-center justify-center text-slate-950 font-black text-2xl shadow-lg shadow-amber-600/20 mb-3">
            <i class="fa-solid fa-car"></i>
        </div>
        <h2 class="text-2xl font-extrabold text-white tracking-wide">Selamat Datang Kembali</h2>
        <p class="text-xs text-gray-400 mt-1">Masukkan kredensial akun Anda untuk masuk ke RentalHub</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-300 font-semibold text-xs uppercase" />
            <x-text-input id="email" 
                          class="block mt-1 w-full bg-[#030712] border-gray-800 text-white rounded-lg focus:border-[#D97706] focus:ring-[#D97706] text-sm" 
                          type="email" 
                          name="email" 
                          :value="old('email')" 
                          placeholder="nama@email.com"
                          required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-xs" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-300 font-semibold text-xs uppercase" />

            <x-text-input id="password" 
                          class="block mt-1 w-full bg-[#030712] border-gray-800 text-white rounded-lg focus:border-[#D97706] focus:ring-[#D97706] text-sm"
                          type="password"
                          name="password"
                          placeholder="••••••••"
                          required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-xs" />
        </div>

        <div class="flex items-center justify-between text-xs pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-800 bg-[#030712] text-[#D97706] shadow-sm focus:ring-[#D97706]" name="remember">
                <span class="ms-2 text-gray-400 hover:text-gray-200">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-[#D97706] hover:underline font-medium" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div class="pt-3">
            <x-primary-button class="w-full justify-center py-3 bg-[#D97706] text-slate-950 font-bold hover:bg-amber-500 active:bg-amber-600 transition duration-150 rounded-xl text-sm tracking-wider uppercase border-none">
                <i class="fa-solid fa-right-to-bracket mr-2"></i> {{ __('Log in') }}
            </x-primary-button>
        </div>

        @if (Route::has('register'))
            <p class="text-center text-xs text-gray-400 pt-4 border-t border-gray-800/80">
                Belum memiliki akun? 
                <a href="{{ route('register') }}" class="text-[#D97706] font-bold hover:underline ml-1">Daftar Akun Baru</a>
            </p>
        @endif
    </form>
</x-guest-layout>