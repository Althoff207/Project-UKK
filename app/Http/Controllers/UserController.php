<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Borrow;

class UserController extends Controller
{
    /**
     * Menampilkan Halaman Katalog Buku (Dashboard Siswa)
     */
    public function index(Request $request)
    {
        // Ambil semua kategori untuk kebutuhan filter di view
        $categories = Category::all();

        // Query buku dengan memanggil relasi kategorinya agar hemat database query
        $query = Book::with('category');

        // Filter kategori jika siswa memilih kategori tertentu
        if ($request->has('category_id') && $request->category_id != 0) {
            $query->where('category_id', $request->category_id);
        }

        $books = $query->get();

        return view('user.dashboard', compact('books', 'categories'));
    }

    public function showChangePassword()
{
    // Pastikan pengecekan is_first_login sudah benar
    if (!auth()->user()->is_first_login) {
        return redirect()->route('user.dashboard');
    }

    return view('user.change_password');
}

// UBAH NAMA METHOD INI agar sesuai dengan web.php (updatePasswordFirstTime)
public function updatePasswordFirstTime(Request $request)
{
    // Validasi input
    $request->validate([
        'password' => 'required|min:8|confirmed',
    ]);

    $user = auth()->user();

    // Update password dan matikan status first_login
    $user->password = Hash::make($request->password);
    $user->is_first_login = false;
    $user->save();

    return redirect()->route('user.dashboard')
        ->with('success', 'Berhasil! Password baru Anda telah disimpan.');
}

    /**
     * Menampilkan Halaman Detail Buku
     */
    public function show($id)
    {
        // Mencari buku berdasarkan ID beserta kategorinya. 
        // findOrFail otomatis memunculkan error 404 jika ID buku tidak ditemukan.
        $book = Book::with('category')->findOrFail($id);

        // Memanggil file detail.blade.php milikmu
        return view('user.detail', compact('book'));
    }

    /**
     * Menampilkan Riwayat Peminjaman Siswa
     */
    public function history()
    {
        // Mengambil riwayat pinjam milik user yang sedang login saja
        $histories = Borrow::with('book')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.history', compact('histories'));
    }
}
