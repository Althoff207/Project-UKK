<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Statistik untuk Dashboard
        $data = [
            'total_user' => User::count(),
            'total_buku' => Book::count(),
            'total_pinjam' => Borrow::where('status', 'approved')->count(),
            'total_kategori' => Category::count(),
        ];

        return view('admin.dashboard', compact('data'));
    }

    public function index(Request $request)
    {
        // Ambil input pencarian dari form
        $search = $request->input('search');

        // Query user: sembunyikan diri sendiri agar admin tidak sengaja menghapus akunnya sendiri
        $users = User::where('id', '!=', auth()->id())
            ->when($search, function ($query) use ($search) {
                // Cari berdasarkan nama ATAU email
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10); // Menambahkan pagination agar tampilan lebih rapi

        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,librarian,user',
            'password' => 'nullable|min:8', // nullable artinya boleh kosong
        ]);

        // Update data dasar
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        // Cek jika password diisi, maka di-hash dan disimpan
        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui sepenuhnya!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User berhasil dihapus!');
    }
}
