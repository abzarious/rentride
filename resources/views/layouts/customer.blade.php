<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RentRide - Sewa Mobil & Motor Premium')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#030712] text-[#F9FAFB] antialiased flex flex-col min-h-screen">

    <header class="bg-[#111827]/90 backdrop-blur-md border-b border-gray-800 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#D97706] to-amber-700 flex items-center justify-center text-slate-950 font-black text-xl shadow-lg shadow-amber-600/20">
                    <i class="fa-solid fa-car"></i>
                </div>
                <span class="text-xl font-extrabold tracking-wider text-white">RENT<span class="text-[#D97706]">RIDE</span></span>
            </a>

            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-300">
                <a href="/" class="hover:text-[#D97706] transition-colors">Beranda</a>
                <a href="#" class="hover:text-[#D97706] transition-colors">Cari Armada</a>
                <a href="#" class="hover:text-[#D97706] transition-colors">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-[#D97706] transition-colors">Kontak Kami</a>
            </nav>

            <div class="flex items-center gap-4">
                @auth
                    <a href="/customer/dashboard" class="px-4 py-2 text-sm font-semibold text-white bg-[#111827] border border-[#D97706] rounded-lg hover:bg-[#D97706] hover:text-slate-950 transition-all shadow-md">
                        <i class="fa-solid fa-user-gear mr-2 text-[#D97706]"></i> Dashboard Saya
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-300 hover:text-white transition">Masuk</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-semibold text-slate-950 bg-[#D97706] rounded-lg hover:bg-amber-500 transition-all shadow-lg shadow-amber-600/20">
                        Daftar Akun
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="bg-[#111827] border-t border-gray-800 pt-12 pb-8 mt-12 text-gray-400 text-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <div>
                <span class="text-lg font-bold text-white tracking-wider">RENTAL<span class="text-[#D97706]">HUB</span></span>
                <p class="mt-3 text-xs leading-relaxed text-gray-400">
                    Layanan persewaan mobil dan motor eksekutif dengan armadanya yang selalu terawat, respon cepat via WhatsApp, dan pemesanan yang aman.
                </p>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3">Layanan Kami</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="#" class="hover:text-[#D97706]">Sewa Mobil Harian</a></li>
                    <li><a href="#" class="hover:text-[#D97706]">Sewa Motor Matic & Sport</a></li>
                    <li><a href="#" class="hover:text-[#D97706]">Layanan Lepas Kunci</a></li>
                    <li><a href="#" class="hover:text-[#D97706]">Layanan Plus Driver</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3">Kontak Bantuan</h4>
                <p class="text-xs text-gray-400 mb-2"><i class="fa-brands fa-whatsapp text-[#059669] mr-2"></i> +62 812-3456-7890</p>
                <p class="text-xs text-gray-400 mb-2"><i class="fa-regular fa-envelope text-[#D97706] mr-2"></i> info@rentalhub.id</p>
                <p class="text-xs text-gray-400"><i class="fa-solid fa-location-dot text-red-500 mr-2"></i> Malang, Jawa Timur</p>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3">Metode Pembayaran</h4>
                <p class="text-xs leading-relaxed mb-3">Transfer Bank Manual (BCA, Mandiri, BRI) dengan Verifikasi WhatsApp Cepat.</p>
                <span class="inline-block px-3 py-1 bg-emerald-950 border border-emerald-600 text-[#059669] text-xs font-semibold rounded-full">
                    <i class="fa-solid fa-shield-halved mr-1"></i> Terverifikasi Aman
                </span>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 border-t border-gray-800/80 pt-6 text-center text-xs text-gray-500">
            &copy; {{ date('Y') }} RentRide Premium Rental Service. All rights reserved.
        </div>
    </footer>

</body>
</html>