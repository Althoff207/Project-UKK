<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
{
    // 1. Cek apakah user sudah login
    if (!auth()->check()) {
        return redirect('login');
    }

    $userRole = auth()->user()->role;

    // 2. SPESIAL: Jika user adalah admin, izinkan akses ke MANA SAJA
    if ($userRole === 'admin') {
        return $next($request);
    }

    // 3. Cek apakah role user ada dalam daftar role yang diizinkan di route
    // (...$roles mengubah parameter menjadi array)
    if (in_array($userRole, $roles)) {
        return $next($request);
    }

    // Jika tidak punya akses sama sekali
    abort(403, 'Anda tidak memiliki akses ke halaman ini.');
}
}
