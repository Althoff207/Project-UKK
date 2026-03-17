<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Kategori - E-Lib</title>
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

    <div class="max-w-4xl mx-auto p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Kategori</h1>
            <a href="{{ route('librarian.categories.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                + Tambah Kategori
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded-lg mb-4 shadow">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-500 text-white p-3 rounded-lg mb-4 shadow">{{ session('error') }}</div>
        @endif

        <div class="bg-white rounded-xl shadow overflow-hidden border">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-4 text-sm font-bold text-gray-600">Nama Kategori</th>
                        <th class="p-4 text-sm font-bold text-gray-600 text-center">Jumlah Buku</th>
                        <th class="p-4 text-sm font-bold text-gray-600 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($categories as $cat)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 font-medium text-gray-900">{{ $cat->name }}</td>
                        <td class="p-4 text-center">
                            <span class="bg-gray-100 text-gray-600 px-2.5 py-0.5 rounded-full text-xs font-bold">{{ $cat->books_count }}</span>
                        </td>
                        <td class="p-4 text-right flex justify-end gap-3 text-sm">
                            <a href="{{ route('librarian.categories.edit', $cat->id) }}" class="text-blue-600 font-bold hover:underline">Edit</a>
                            <form action="{{ route('librarian.categories.destroy', $cat->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 font-bold hover:underline" onclick="return confirm('Hapus kategori ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-8 text-center text-gray-400 italic">Belum ada kategori.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>