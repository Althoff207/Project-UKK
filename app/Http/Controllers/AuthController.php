<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function showLogin()
    {
        // Pastikan file ini ada di resources/views/auth/login.blade.php
        return view('auth.login');
    }

    /**
     * Memproses data login
     */
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba melakukan autentikasi
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Ambil role user yang baru saja login
            $role = Auth::user()->role;

            /**
             * Logika Redirect Berdasarkan Role
             * Menggunakan route() agar otomatis menyesuaikan dengan prefix di web.php
             */
            if ($role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            } 
            
            if ($role === 'librarian') {
                return redirect()->intended(route('librarian.dashboard'));
            }

            // Untuk role 'user' (Siswa), arahkan ke prefix /user/dashboard
            if ($role === 'user') {
                return redirect()->intended(route('user.dashboard'));
            }

            // Fallback jika role tidak terdefinisi
            return redirect('/');
        }

        // Jika login gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Proses Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Bersihkan session agar aman
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Kembali ke halaman login
        return redirect('/login');
    }
}