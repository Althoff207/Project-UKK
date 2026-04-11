<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForceChangePassword
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Cek apakah user sudah login, role-nya 'user', dan is_first_login masih true
        if (Auth::check() && Auth::user()->role === 'user' && Auth::user()->is_first_login) {

            // 2. Cek apakah rute saat ini mengandung 'password'. 
            // Kita gunakan wildcard (*) agar mencakup 'user.password.first-login' 
            // dan 'user.password.update-first'
            if (!$request->routeIs('user.password.*')) {
                
                // 3. REDIRECT ke nama rute yang benar sesuai web.php
                return redirect()->route('user.password.first-login')
                    ->with('warning', 'Demi keamanan, wajib ubah password default Anda terlebih dahulu.');
            }
        }

        return $next($request);
    }
}