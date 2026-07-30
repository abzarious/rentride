<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-white">Buat Akun Baru</h2>
        <p class="text-xs text-gray-400 mt-1">Daftar sekarang untuk mulai menyewa kendaraan impian Anda</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-xs font-semibold text-gray-300 uppercase mb-1.5">Nama Lengkap</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-500">
                    <i class="fa-solid fa-user text-sm"></i>
                </span>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                    placeholder="Contoh: Budi Santoso"
                    class="w-full pl-10 pr-4 py-2.5 bg-[#030712] border border-gray-800 rounded-xl text-white text-sm focus:border-[#D97706] focus:ring-1 focus:ring-[#D97706] focus:outline-none transition">
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <div>
            <label for="email" class="block text-xs font-semibold text-gray-300 uppercase mb-1.5">Alamat Email</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-500">
                    <i class="fa-solid fa-envelope text-sm"></i>
                </span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                    placeholder="nama@email.com"
                    class="w-full pl-10 pr-4 py-2.5 bg-[#030712] border border-gray-800 rounded-xl text-white text-sm focus:border-[#D97706] focus:ring-1 focus:ring-[#D97706] focus:outline-none transition">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div>
            <label for="phone" class="block text-xs font-semibold text-gray-300 uppercase mb-1.5">Nomor WhatsApp / HP</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-500">
                    <i class="fa-brands fa-whatsapp text-sm text-[#059669]"></i>
                </span>
                <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required placeholder="081234567890"
                    class="w-full pl-10 pr-4 py-2.5 bg-[#030712] border border-gray-800 rounded-xl text-white text-sm focus:border-[#D97706] focus:ring-1 focus:ring-[#D97706] focus:outline-none transition">
            </div>
            <x-input-error :messages="$errors->get('phone')" class="mt-1" />
        </div>

        <div>
            <label for="password" class="block text-xs font-semibold text-gray-300 uppercase mb-1.5">Kata Sandi</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-500">
                    <i class="fa-solid fa-lock text-sm"></i>
                </span>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    placeholder="Minimal 8 karakter"
                    class="w-full pl-10 pr-4 py-2.5 bg-[#030712] border border-gray-800 rounded-xl text-white text-sm focus:border-[#D97706] focus:ring-1 focus:ring-[#D97706] focus:outline-none transition">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div>
            <label for="password_confirmation" class="block text-xs font-semibold text-gray-300 uppercase mb-1.5">Konfirmasi Kata Sandi</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-500">
                    <i class="fa-solid fa-shield-halved text-sm"></i>
                </span>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    placeholder="Ulangi kata sandi"
                    class="w-full pl-10 pr-4 py-2.5 bg-[#030712] border border-gray-800 rounded-xl text-white text-sm focus:border-[#D97706] focus:ring-1 focus:ring-[#D97706] focus:outline-none transition">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full py-3 bg-[#D97706] hover:bg-amber-500 text-slate-950 font-bold rounded-xl text-sm transition shadow-lg shadow-amber-600/20 flex items-center justify-center gap-2">
                <i class="fa-solid fa-user-plus"></i> Daftar Akun Sekarang
            </button>
        </div>

        <div class="text-center pt-3 border-t border-gray-800/80">
            <p class="text-xs text-gray-400">
                Sudah memiliki akun? 
                <a href="{{ route('login') }}" class="text-[#D97706] font-semibold hover:underline">Masuk di sini</a>
            </p>
        </div>
    </form>
</x-guest-layout>