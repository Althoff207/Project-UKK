<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BorrowController extends Controller
{
    public function store(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        // 1. Cek stok buku
        if ($book->stock <= 0) {
            return back()->with('error', 'Stok buku habis!');
        }

        // 2. Simpan data ke tabel borrows
        Borrow::create([
            'user_id'         => auth()->id(),
            'book_id'         => $book->id,
            'borrow_type'     => 'fisik', // Default, bisa diubah jika ada pilihan
            'borrow_date'     => Carbon::now(),
            'return_due_date' => Carbon::now()->addDays(7), // Pinjam 7 hari
            'status'          => 'pending',
        ]);

        // 3. Kurangi stok buku
        $book->decrement('stock');

        return back()->with('success', 'Permintaan pinjam berhasil dikirim! Silakan tunggu konfirmasi petugas.');
    }
    public function borrowedBooks()
{
    $borrows = Borrow::with(['user', 'book'])
        ->where('status', 'approved')
        ->latest()
        ->get();
        
    return view('librarian.return', compact('borrows'));
}

// Proses pengembalian buku
public function returnBook($id)
{
    $borrow = Borrow::findOrFail($id);
    
    // 1. Update status dan tanggal kembali
    $borrow->update([
        'status' => 'returned',
        'return_date' => Carbon::now()
    ]);

    // 2. Tambah kembali stok buku
    $book = Book::find($borrow->book_id);
    $book->increment('stock');

    return back()->with('success', 'Buku telah berhasil dikembalikan!');
}
}
