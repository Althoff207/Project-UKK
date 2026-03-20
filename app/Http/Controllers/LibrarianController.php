<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LibrarianController extends Controller
{
   public function index()
{
    $data = [
        'total_buku'           => Book::count(),
        'total_kategori'       => Category::count(),
        // Buku yang menunggu aksi petugas (Approval)
        'total_pending'        => Borrow::where('status', 'pending')->count(), 
        // Buku yang statusnya sedang dibawa siswa (Sedang Dipinjam)
        'total_sedang_dipinjam' => Borrow::where('status', 'borrowed')->count(), 
    ];

    return view('librarian.dashboard', compact('data'));
}

public function approvalList()
{
    // Hanya mengambil status pending
    $requests = Borrow::with(['user', 'book'])
        ->where('status', 'pending')
        ->latest()
        ->get();

    return view('librarian.approval', compact('requests'));
}

    public function updateStatus(Request $request, $id, $status)
    {
        $borrow = Borrow::findOrFail($id);
        
        if ($status === 'rejected') {
            $book = Book::find($borrow->book_id);
            if ($book) $book->increment('stock');
        }

        $borrow->update(['status' => $status]);
        return back()->with('success', 'Status berhasil diperbarui!');
    }

    public function borrowedBooks()
{
    $borrows = Borrow::with(['user', 'book'])->where('status', 'borrowed')->get();
    return view('librarian.return', compact('borrows')); // Memanggil librarian/return.blade.php
}

    public function returnBook($id)
    {
        $borrow = Borrow::findOrFail($id);
        
        $borrow->update([
            'status' => 'returned',
            'return_date' => Carbon::now()
        ]);

        $book = Book::find($borrow->book_id);
        if ($book) {
            $book->increment('stock');
        }

        return back()->with('success', 'Buku telah berhasil dikembalikan!');
    }
}