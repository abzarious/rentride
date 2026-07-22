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
        <x-sidebar.admin-sidebar />

        <div class="flex-1 flex flex-col min-w-0 overflow-x-hidden">
            <x-navbar.admin-navbar />

            <main class="flex-1 p-6">
                @yield('content')
            </main>

            <footer class="bg-white border-t border-slate-200 p-4 text-center text-xs text-slate-500">
                &copy; {{ date('Y') }} RentRide Premium System. All rights reserved.
            </footer>
        </div>
    </div>

</body>
</html>