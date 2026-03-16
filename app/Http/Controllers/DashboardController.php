<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function userIndex()
    {
        // Ambil buku yang tersedia (stock > 0)
        $books = Book::with('category')->where('stock', '>', 0)->get();
        return view('dashboard', compact('books'));
    }

    public function librarianIndex()
    {
        // Statistik singkat untuk Librarian
        $totalBooks = Book::count();
        $pendingBorrows = Borrow::where('status', 'pending')->count();
        return view('librarian.dashboard', compact('totalBooks', 'pendingBorrows'));
    }
}
