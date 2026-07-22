<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek Apakah User Sudah Login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Cek Apakah Role Sesuai dengan Parameter Route
        if ($request->user()->role !== $role) {
            // Jika role tidak sesuai, alihkan ke dashboard masing-masing
            if ($request->user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('customer.dashboard');
        }

        return $next($request);
    }
}