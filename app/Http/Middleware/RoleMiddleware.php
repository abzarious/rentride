<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek apakah user sudah terautentikasi
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Cek apakah akun aktif
        if (!Auth::user()->status) {
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'Akun Anda dinonaktifkan oleh Admin.']);
        }

        // 3. Cek kesesuaian role
        if (Auth::user()->role === $role) {
            return $next($request);
        }

        // Jika tidak berhak, kembalikan response 403 Forbidden
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}