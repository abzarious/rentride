<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $setting->company_name ?? 'RentRide' }} - Sewa Mobil & Motor Premium</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#030712] text-[#F9FAFB] antialiased flex flex-col min-h-screen selection:bg-[#D97706] selection:text-black">

    <header class="bg-[#111827]/80 backdrop-blur-md border-b border-gray-800/80 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3 group">
                @if($setting->logo ?? false)
                    <img src="{{ asset('storage/' . $setting->logo) }}" class="w-10 h-10 object-contain">
                @else
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#D97706] to-amber-700 flex items-center justify-center text-slate-950 font-black text-xl shadow-lg shadow-amber-600/20 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-car-side"></i>
                    </div>
                @endif
                <span class="text-xl font-extrabold tracking-wider text-white">
                    {{ strtoupper($setting->company_name ?? 'RentRide') }}
                </span>
            </a>

            @if (Route::has('login'))
                <nav class="flex items-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 text-sm font-semibold text-slate-950 bg-[#D97706] rounded-xl hover:bg-amber-500 transition shadow-lg shadow-amber-600/20 flex items-center gap-2">
                            <i class="fa-solid fa-gauge-high"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-gray-300 hover:text-white transition">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-semibold text-slate-950 bg-[#D97706] rounded-xl hover:bg-amber-500 transition shadow-lg shadow-amber-600/20">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    <main class="flex-1">
        <section class="relative py-20 lg:py-28 overflow-hidden">
            <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[300px] bg-[#D97706]/10 blur-[120px] rounded-full pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                
                <h1 class="text-4xl sm:text-6xl font-black text-white tracking-tight leading-tight max-w-4xl mx-auto">
                    Pengalaman Berkendara Premium Tanpa Batas Bersama <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#D97706] via-amber-400 to-amber-600">{{ $setting->company_name ?? 'RentRide' }}</span>
                </h1>

                <p class="mt-6 text-base sm:text-lg text-gray-400 max-w-2xl mx-auto leading-relaxed">
                    Sewa mobil dan motor impian Anda dengan proses booking online yang mudah, durasi fleksibel, dan konfirmasi langsung via WhatsApp tanpa ribet.
                </p>

                <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto px-8 py-4 bg-[#D97706] text-slate-950 font-bold rounded-xl hover:bg-amber-500 transition shadow-xl shadow-amber-600/20 text-sm flex items-center justify-center gap-2">
                            <i class="fa-solid fa-car"></i> Cari & Sewa Kendaraan
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-[#D97706] text-slate-950 font-bold rounded-xl hover:bg-amber-500 transition shadow-xl shadow-amber-600/20 text-sm flex items-center justify-center gap-2">
                            Mulai Sewa Sekarang <i class="fa-solid fa-arrow-right"></i>
                        </a>
                        <a href="https://wa.me/{{ $setting->whatsapp ?? '6281234567890' }}" target="_blank" class="w-full sm:w-auto px-8 py-4 bg-[#111827] text-emerald-400 font-semibold rounded-xl border border-gray-800 hover:border-emerald-600 transition text-sm flex items-center justify-center gap-2">
                            <i class="fa-brands fa-whatsapp text-lg"></i> Tanya Admin via WA
                        </a>
                    @endauth
                </div>

                <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-6 pt-10 border-t border-gray-800/80">
                    <div class="p-4 rounded-xl bg-[#111827]/50 border border-gray-800/50">
                        <h3 class="text-2xl font-extrabold text-white">100+</h3>
                        <p class="text-xs text-gray-400 mt-1">Armada Ready</p>
                    </div>
                    <div class="p-4 rounded-xl bg-[#111827]/50 border border-gray-800/50">
                        <h3 class="text-2xl font-extrabold text-[#059669]">24/7</h3>
                        <p class="text-xs text-gray-400 mt-1">Respon WA Fast</p>
                    </div>
                    <div class="p-4 rounded-xl bg-[#111827]/50 border border-gray-800/50">
                        <h3 class="text-2xl font-extrabold text-white">Custom</h3>
                        <p class="text-xs text-gray-400 mt-1">Durasi Fleksibel</p>
                    </div>
                    <div class="p-4 rounded-xl bg-[#111827]/50 border border-gray-800/50">
                        <h3 class="text-2xl font-extrabold text-[#D97706]">100%</h3>
                        <p class="text-xs text-gray-400 mt-1">Verifikasi Transparan</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-[#030712] border-t border-gray-800/80 py-8 text-center text-xs text-gray-500">
        <div class="max-w-7xl mx-auto px-4">
            <p>&copy; {{ date('Y') }} {{ $setting->company_name ?? 'RentRide' }} System. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>