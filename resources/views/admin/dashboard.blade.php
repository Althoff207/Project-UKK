<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Superadmin - E-Lib</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-red-700 shadow-lg text-white">
        <div class="max-w-7xl mx-auto px-4 h-16 flex justify-between items-center">
            <div class="flex gap-6 items-center">
                <span class="font-bold text-xl tracking-wider">SUPERADMIN</span>
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold border-b-2 border-white py-2">Dashboard</a>
                <a href="{{ route('admin.users.index') }}" class="text-sm opacity-80 hover:opacity-100">Kelola User</a>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-sm bg-red-800 px-4 py-2 rounded hover:bg-red-900 transition">Logout</button>
            </form>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-8 text-gray-800">Selamat Datang, {{ auth()->user()->name }} 👋</h1>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-red-500">
                <p class="text-xs font-bold text-gray-500 uppercase">Total Pengguna</p>
                <p class="text-2xl font-black text-gray-800">{{ $data['total_user'] }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-indigo-500">
                <p class="text-xs font-bold text-gray-500 uppercase">Koleksi Buku</p>
                <p class="text-2xl font-black text-gray-800">{{ $data['total_buku'] }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500">
                <p class="text-xs font-bold text-gray-500 uppercase">Sedang Dipinjam</p>
                <p class="text-2xl font-black text-gray-800">{{ $data['total_pinjam'] }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500">
                <p class="text-xs font-bold text-gray-500 uppercase">Kategori Buku</p>
                <p class="text-2xl font-black text-gray-800">{{ $data['total_kategori'] }}</p>
            </div>
        </div>

        <h2 class="text-lg font-bold mb-4 text-gray-700">Akses Cepat Panel</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('user.dashboard') }}" class="group bg-white p-8 rounded-2xl shadow-sm border hover:border-blue-500 transition-all">
                <div class="text-blue-500 mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h3 class="font-bold text-gray-800 group-hover:text-blue-600">Halaman Katalog (Siswa)</h3>
                <p class="text-sm text-gray-500">Lihat tampilan buku sebagai siswa.</p>
            </a>

            <a href="{{ route('librarian.dashboard') }}" class="group bg-white p-8 rounded-2xl shadow-sm border hover:border-indigo-500 transition-all">
                <div class="text-indigo-500 mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <h3 class="font-bold text-gray-800 group-hover:text-indigo-600">Halaman Petugas (Librarian)</h3>
                <p class="text-sm text-gray-500">Kelola buku, kategori, dan transaksi.</p>
            </a>

            <a href="{{ route('admin.users.index') }}" class="group bg-white p-8 rounded-2xl shadow-sm border hover:border-red-500 transition-all">
                <div class="text-red-500 mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <h3 class="font-bold text-gray-800 group-hover:text-red-600">Manajemen Pengguna</h3>
                <p class="text-sm text-gray-500">Ubah role user atau hapus akun.</p>
            </a>
        </div>
    </div>
</body>
</html>