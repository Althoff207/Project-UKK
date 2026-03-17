<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Buku - E-Lib</title>
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

    <div class="max-w-7xl mx-auto p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Daftar Koleksi Buku</h1>
            <a href="{{ route('librarian.books.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">Tambah Buku</a>
        </div>

        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded shadow overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-4">Cover</th>
                        <th class="p-4">Judul</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Stok</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $b)
                    <tr class="border-b">
                        <td class="p-4">
                            <img src="{{ asset('storage/'.$b->book_cover) }}" class="h-16 w-12 object-cover rounded">
                        </td>
                        <td class="p-4 font-bold">{{ $b->title }}</td>
                        <td class="p-4">{{ $b->category->name }}</td>
                        <td class="p-4">{{ $b->stock }}</td>
                        <td class="p-4 flex gap-2">
                            <a href="{{ route('librarian.books.edit', $b->id) }}" class="text-blue-600">Edit</a>
                            <form action="{{ route('librarian.books.destroy', $b->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600" onclick="return confirm('Hapus buku ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>