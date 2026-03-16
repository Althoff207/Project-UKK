<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LibrarySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Contoh
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Petugas Perpustakaan',
            'email' => 'librarian@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'librarian',
        ]);

        User::create([
            'name' => 'Siswa User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        // 2. Buat Kategori Contoh
        $cat1 = Category::create(['name' => 'Fiksi']);
        $cat2 = Category::create(['name' => 'Teknologi']);

        // 3. Buat Buku Contoh
        Book::create([
            'title' => 'Laskar Pelangi',
            'author' => 'Andrea Hirata',
            'publisher' => 'Bentang Pustaka',
            'year' => 2005,
            'stock' => 10,
            'category_id' => $cat1->id,
        ]);

        Book::create([
            'title' => 'Belajar Laravel 12',
            'author' => 'Coder Indonesia',
            'publisher' => 'Tech Media',
            'year' => 2024,
            'stock' => 5,
            'category_id' => $cat2->id,
        ]);
    }
}