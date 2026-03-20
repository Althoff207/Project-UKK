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
            'total_buku'            => Book::count(),
            'total_kategori'        => Category::count(),
            // Buku yang menunggu aksi petugas (Approval)
            'total_pending'         => Borrow::where('status', 'pending')->count(), 
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

    /**
     * PERBAIKAN: Menangani update status dari Approval
     */
    public function updateStatus(Request $request, $id, $status)
    {
        $borrow = Borrow::findOrFail($id);
        
        // Mencegah error "Data truncated": 
        // Jika dari view dikirim 'approved', kita ubah jadi 'borrowed' agar sesuai ENUM database
        $finalStatus = $status;
        if ($status === 'approved') {
            $finalStatus = 'borrowed';
        }

        // Jika ditolak, stok buku harus dikembalikan (karena saat user klik pinjam, biasanya stok sudah berkurang)
        if ($finalStatus === 'rejected') {
            $book = Book::find($borrow->book_id);
            if ($book) {
                $book->increment('stock');
            }
        }

        $borrow->update(['status' => $finalStatus]);
        
        return back()->with('success', 'Permintaan peminjaman berhasil diproses!');
    }

    public function borrowedBooks()
    {
        // Menampilkan buku yang statusnya sedang dipinjam (untuk proses pengembalian)
        $borrows = Borrow::with(['user', 'book'])
            ->where('status', 'borrowed')
            ->latest()
            ->get();
            
        return view('librarian.return', compact('borrows'));
    }

    public function returnBook($id)
    {
        $borrow = Borrow::findOrFail($id);
        
        // Update status menjadi returned dan catat tanggal pengembalian
        $borrow->update([
            'status' => 'returned',
            'return_date' => Carbon::now()
        ]);

        // Tambah kembali stok buku
        $book = Book::find($borrow->book_id);
        if ($book) {
            $book->increment('stock');
        }

        return back()->with('success', 'Buku telah berhasil dikembalikan!');
    }
}