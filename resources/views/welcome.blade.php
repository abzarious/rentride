<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $setting->company_name ?? 'RentRide' }} - Sewa Mobil & Motor Premium</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
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
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-gray-300 hover:text-white transition">Log in</a>
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
        <section class="relative py-16 lg:py-20 overflow-hidden border-b border-gray-800/80">
            <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[300px] bg-[#D97706]/10 blur-[120px] rounded-full pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <h1 class="text-4xl sm:text-6xl font-black text-white tracking-tight leading-tight max-w-4xl mx-auto">
                    Pengalaman Berkendara Premium Tanpa Batas Bersama <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#D97706] via-amber-400 to-amber-600">{{ $setting->company_name ?? 'RentRide' }}</span>
                </h1>

                <p class="mt-4 text-base sm:text-lg text-gray-400 max-w-2xl mx-auto leading-relaxed">
                    Sewa mobil dan motor impian Anda dengan proses booking online yang mudah, durasi fleksibel, dan konfirmasi langsung via WhatsApp tanpa ribet.
                </p>

                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="#katalog" class="w-full sm:w-auto px-8 py-4 bg-[#D97706] text-slate-950 font-bold rounded-xl hover:bg-amber-500 transition shadow-xl shadow-amber-600/20 text-sm flex items-center justify-center gap-2">
                        <i class="fa-solid fa-car"></i> Lihat Katalog Armada
                    </a>
                </div>
            </div>
        </section>

        <section id="katalog" class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 gap-4">
                <div>
                    <span class="text-xs font-bold text-[#D97706] uppercase tracking-widest">Armada Siap Sewa</span>
                    <h2 class="text-3xl font-black text-white mt-1">Katalog Kendaraan Kami</h2>
                    <p class="text-xs text-gray-400 mt-1">Pilih kendaraan pilihan Anda dan langsung lakukan reservasi online.</p>
                </div>
            </div>

            @if(isset($vehicles) && $vehicles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($vehicles as $v)
                        <div class="bg-[#111827] border border-gray-800 rounded-2xl overflow-hidden shadow-xl hover:border-[#D97706]/50 transition duration-300 flex flex-col justify-between">
                            <div>
                                <div class="h-48 bg-gray-900 relative overflow-hidden">
                                    @if($v->thumbnail)
                                        <img src="{{ asset('storage/' . $v->thumbnail) }}" alt="{{ $v->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-700">
                                            <i class="fa-solid fa-car text-5xl"></i>
                                        </div>
                                    @endif
                                    <div class="absolute top-3 right-3">
                                        <span class="px-3 py-1 bg-black/70 backdrop-blur-md text-[#D97706] text-[10px] font-bold rounded-full uppercase border border-amber-500/30">
                                            {{ $v->category->name ?? 'Armada' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="p-5">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ $v->brand->name ?? 'Brand' }}</span>
                                    <h3 class="text-lg font-bold text-white mt-0.5">{{ $v->name }}</h3>

                                    <div class="grid grid-cols-2 gap-2 mt-4 text-xs text-gray-400 border-t border-b border-gray-800/80 py-3">
                                        <div><i class="fa-solid fa-gears text-[#D97706] mr-1.5"></i> {{ ucfirst($v->transmission) }}</div>
                                        <div><i class="fa-solid fa-gas-pump text-[#D97706] mr-1.5"></i> {{ ucfirst($v->fuel_type) }}</div>
                                        <div><i class="fa-solid fa-calendar text-[#D97706] mr-1.5"></i> Tahun {{ $v->year }}</div>
                                        <div><i class="fa-solid fa-palette text-[#D97706] mr-1.5"></i> {{ $v->color }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-5 pt-0 flex items-center justify-between gap-4">
                                <div>
                                    <span class="text-[10px] text-gray-400 block">Tarif Sewa</span>
                                    <span class="text-base font-extrabold text-[#D97706]">Rp {{ number_format($v->price_per_day, 0, ',', '.') }}</span>
                                    <span class="text-[10px] text-gray-500">/hari</span>
                                </div>
                                
                                @auth
                                    <a href="{{ route('vehicles.show', $v->id) }}" class="px-4 py-2 bg-[#D97706] text-slate-950 font-bold rounded-xl hover:bg-amber-500 text-xs transition shadow-lg shadow-amber-600/20">
                                        Detail & Sewa
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="px-4 py-2 bg-[#D97706] text-slate-950 font-bold rounded-xl hover:bg-amber-500 text-xs transition shadow-lg shadow-amber-600/20">
                                        <i class="fa-solid fa-right-to-bracket mr-1"></i> Login untuk Sewa
                                    </a>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <x-empty.empty-data title="Belum Ada Armada Available" description="Saat ini belum ada kendaraan yang siap disewa. Silakan hubungi admin via WhatsApp." />
            @endif
        </section>
    </main>

    <footer class="bg-[#030712] border-t border-gray-800/80 py-8 text-center text-xs text-gray-500">
        <div class="max-w-7xl mx-auto px-4">
            <p>&copy; {{ date('Y') }} {{ $setting->company_name ?? 'RentRide' }} System. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>