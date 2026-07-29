<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RentRide') }} - Masuk Akun</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#030712] text-[#F9FAFB] antialiased min-h-screen flex flex-col justify-center items-center px-4 py-8">

    <div class="mb-6 text-center">
        <a href="/" class="inline-flex items-center gap-3 group">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#D97706] to-amber-700 flex items-center justify-center text-slate-950 font-black text-2xl shadow-lg shadow-amber-600/30 group-hover:scale-105 transition duration-200">
                <i class="fa-solid fa-car"></i>
            </div>
            <span class="text-2xl font-black tracking-wider text-white">RENT<span class="text-[#D97706]">RIDE</span></span>
        </a>
    </div>

    <div class="w-full sm:max-w-md bg-[#111827] border border-gray-800/80 rounded-2xl p-8 shadow-2xl relative overflow-hidden">
        <div class="absolute -top-12 -right-12 w-32 h-32 bg-[#D97706]/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-12 -left-12 w-32 h-32 bg-emerald-600/10 rounded-full blur-2xl pointer-events-none"></div>

        {{ $slot }}
    </div>

    <div class="mt-8 text-center text-xs text-gray-500">
        &copy; {{ date('Y') }} RentRide Premium Rental System. All rights reserved.
    </div>

</body>
</html>