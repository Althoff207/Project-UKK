<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Borrow;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Ambil kategori untuk filter (seperti di dashboard.php lama kamu)
        $categories = Category::all();

        // Query buku dengan filter kategori jika ada
        $query = Book::with('category');

        if ($request->has('category_id') && $request->category_id != 0) {
            $query->where('category_id', $request->category_id);
        }

        $books = $query->get();

        return view('user.dashboard', compact('books', 'categories'));
    }

    public function history()
{
    // Mengambil riwayat pinjam milik user yang login, urutkan dari yang terbaru
    $histories = Borrow::with('book')
        ->where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->get();

    return view('user.history', compact('histories'));
}
// Menampilkan halaman tambah (Single & Bulk)
public function create()
{
    return view('admin.users.create');
}

// Menyimpan single user
public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8',
        'role' => 'required'
    ]);

    \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => $request->role,
    ]);

    return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan!');
}

// Logika Import Massal (Dasar)
public function import(Request $request)
{
    $request->validate(['file' => 'required|mimes:csv,txt,xlsx']);
    
    // Di sini nanti kamu bisa pakai Laravel Excel untuk baca file-nya
    // Untuk sementara kita arahkan kembali dengan pesan sukses
    return redirect()->route('admin.users.index')->with('success', 'Data masal sedang diproses!');
}
}
