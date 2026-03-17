<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Buku - E-Lib</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
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
    <div class="max-w-3xl mx-auto py-12 px-4">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-indigo-600 p-6">
                <h2 class="text-xl font-bold text-white">Tambah Koleksi Buku Baru</h2>
            </div>
            
            <form action="{{ route('librarian.books.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Judul Buku</label>
                        <input type="text" name="title" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border p-2.5" placeholder="Contoh: Laskar Pelangi" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Penulis</label>
                        <input type="text" name="author" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border p-2.5" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                        <select name="category_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border p-2.5" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Stok Buku</label>
                        <input type="number" name="stock" min="1" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border p-2.5" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Cover Buku (Gambar)</label>
                        <input type="file" name="book_cover" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t">
                    <a href="{{ route('librarian.books.index') }}" class="text-sm font-bold text-gray-500 hover:text-gray-700">Batal</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-lg transition shadow-md">
                        Simpan Buku
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>