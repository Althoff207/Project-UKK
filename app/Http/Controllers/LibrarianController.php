<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Book;
use Illuminate\Http\Request;
use Carbon\Carbon; // Pastikan Carbon di-import

class LibrarianController extends Controller
{
    // Halaman Persetujuan (Pending)
    public function index()
    {
        $requests = Borrow::with(['user', 'book'])->where('status', 'pending')->latest()->get();
        return view('librarian.dashboard', compact('requests'));
    }

    // Fungsi untuk Update Status (Approve/Reject)
    public function updateStatus(Request $request, $id, $status)
    {
        $borrow = Borrow::findOrFail($id);
        
        if ($status === 'rejected') {
            $book = Book::find($borrow->book_id);
            $book->increment('stock');
        }

        $borrow->update(['status' => $status]);
        return back()->with('success', 'Status berhasil diperbarui!');
    }

    // --- PASTIKAN FUNGSI INI ADA ---
    public function borrowedBooks()
    {
        // Ambil data yang statusnya 'approved' (sedang dipinjam)
        $borrows = Borrow::with(['user', 'book'])
            ->where('status', 'approved')
            ->latest()
            ->get();
            
        return view('librarian.return', compact('borrows'));
    }

    // Fungsi untuk Proses Pengembalian
    public function returnBook($id)
    {
        $borrow = Borrow::findOrFail($id);
        
        $borrow->update([
            'status' => 'returned',
            'return_date' => Carbon::now()
        ]);

        $book = Book::find($borrow->book_id);
        $book->increment('stock');

        return back()->with('success', 'Buku telah berhasil dikembalikan!');
    }
}
