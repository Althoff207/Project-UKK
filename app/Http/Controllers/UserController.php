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
}
