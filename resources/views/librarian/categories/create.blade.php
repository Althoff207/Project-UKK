<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kategori - E-Lib</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-indigo-700 shadow-lg mb-8 text-white">
    <div class="max-w-7xl mx-auto px-4 h-16 flex justify-between items-center">
        <div class="flex gap-6 items-center">
            <span class="font-bold text-xl tracking-wider mr-4">ALPUS LIBRARIAN</span>
            
            {{-- Tombol Khusus Admin --}}
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="bg-red-600 hover:bg-red-700 text-white text-[10px] px-3 py-1 rounded-full font-bold uppercase tracking-wider transition-all shadow-sm">
                    Kembali ke Admin
                </a>
            @endif

            <a href="{{ route('librarian.dashboard') }}" class="text-sm {{ request()->routeIs('librarian.dashboard') ? 'font-bold border-b-2 border-white' : 'opacity-80 hover:opacity-100' }} py-2">Persetujuan</a>
            <a href="{{ route('librarian.returns') }}" class="text-sm {{ request()->routeIs('librarian.returns') ? 'font-bold border-b-2 border-white' : 'opacity-80 hover:opacity-100' }} py-2">Pengembalian</a>
            <a href="{{ route('librarian.books.index') }}" class="text-sm {{ request()->routeIs('librarian.books.*') ? 'font-bold border-b-2 border-white' : 'opacity-80 hover:opacity-100' }} py-2">Kelola Buku</a>
            <a href="{{ route('librarian.categories.index') }}" class="text-sm {{ request()->routeIs('librarian.categories.*') ? 'font-bold border-b-2 border-white' : 'opacity-80 hover:opacity-100' }} py-2">Kategori</a>
        </div>
        
        <div class="flex items-center gap-4">
            <span class="text-xs italic opacity-70">{{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-sm bg-indigo-800 px-4 py-2 rounded hover:bg-red-600 transition">Logout</button>
            </form>
        </div>
    </div>
</nav>

    <div class="flex items-center justify-center py-20 px-4">
        <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md border">
            <h2 class="text-xl font-bold mb-6 text-gray-800 border-b pb-4">Tambah Kategori Baru</h2>
            
            <form action="{{ route('librarian.categories.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Kategori</label>
                    <input type="text" name="name" class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Masukkan nama kategori..." required>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('librarian.categories.index') }}" class="px-4 py-2 text-sm font-bold text-gray-500">Batal</a>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-bold text-sm shadow-md hover:bg-indigo-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>