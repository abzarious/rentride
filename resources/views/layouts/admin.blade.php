<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - RentRide')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased">

    <div class="min-h-screen flex">
        <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between hidden md:flex shrink-0">
            <div>
                <div class="h-16 flex items-center px-6 bg-slate-950 font-bold text-xl text-white tracking-wider border-b border-slate-800">
                    <i class="fa-solid fa-car-side text-amber-500 mr-3"></i> RENT<span class="text-amber-500">RIDE</span>
                </div>

                <nav class="p-4 space-y-1 text-sm font-medium">
                    <a href="/admin/dashboard" class="flex items-center px-4 py-3 rounded-lg text-white bg-amber-600 font-semibold transition">
                        <i class="fa-solid fa-chart-line w-6"></i> Dashboard
                    </a>
                    
                    <div class="pt-4 pb-1 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Master Data</div>
                    <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition">
                        <i class="fa-solid fa-motorcycle w-6"></i> Kendaraan
                    </a>
                    <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition">
                        <i class="fa-solid fa-layer-group w-6"></i> Kategori & Brand
                    </a>
                    <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition">
                        <i class="fa-solid fa-tags w-6"></i> Promo & Voucher
                    </a>

                    <div class="pt-4 pb-1 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Transaksi</div>
                    <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition">
                        <i class="fa-solid fa-calendar-check w-6"></i> Data Booking
                    </a>
                    <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition">
                        <i class="fa-solid fa-file-invoice-dollar w-6"></i> Verifikasi Pembayaran
                    </a>
                    <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition">
                        <i class="fa-solid fa-triangle-exclamation w-6"></i> Denda & Pengembalian
                    </a>

                    <div class="pt-4 pb-1 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Laporan & Akses</div>
                    <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition">
                        <i class="fa-solid fa-chart-pie w-6"></i> Laporan Keuangan
                    </a>
                    <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition">
                        <i class="fa-solid fa-gear w-6"></i> Pengaturan Website
                    </a>
                </nav>
            </div>

            <div class="p-4 border-t border-slate-800">
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-amber-500 text-slate-900 font-bold flex items-center justify-center">
                            AD
                        </div>
                        <div>
                            <p class="font-semibold text-white text-xs">Administrator</p>
                            <p class="text-[10px] text-slate-400">admin@rentalhub.com</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-red-400 p-2">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 overflow-x-hidden">
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 sticky top-0 z-10">
                <div class="flex items-center gap-4">
                    <button class="md:hidden text-slate-600 focus:outline-none">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <h2 class="text-lg font-bold text-slate-800">@yield('page_title', 'Dashboard')</h2>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-xs bg-slate-100 border border-slate-300 text-slate-600 px-3 py-1 rounded-full font-medium">
                        <i class="fa-regular fa-calendar mr-1"></i> {{ date('d M Y') }}
                    </span>
                    <button class="relative text-slate-500 hover:text-slate-700">
                        <i class="fa-regular fa-bell text-lg"></i>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[9px] rounded-full px-1">3</span>
                    </button>
                </div>
            </header>

            <main class="flex-1 p-6">
                @yield('content')
            </main>

            <footer class="bg-white border-t border-slate-200 p-4 text-center text-xs text-slate-500">
                &copy; {{ date('Y') }} RentalHub Premium System. All rights reserved.
            </footer>
        </div>
    </div>

</body>
</html>