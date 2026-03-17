<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Panel Petugas - E-Lib</title>
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

    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Persetujuan Peminjaman</h1>

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-6 shadow-md">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Peminjam</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Buku</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Tgl Pinjam</th>
                        <th class="px-6 py-4 text-sm font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($requests as $req)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-800">{{ $req->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $req->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-gray-700">{{ $req->book->title }}</td>
                            <td class="px-6 py-4 text-sm">
                                {{ \Carbon\Carbon::parse($req->borrow_date)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 flex gap-2">
                                <form action="{{ route('librarian.borrow.update', [$req->id, 'approved']) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded text-xs font-bold transition">Setujui</button>
                                </form>
                                
                                <form action="{{ route('librarian.borrow.update', [$req->id, 'rejected']) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded text-xs font-bold transition">Tolak</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-400">Belum ada permintaan pinjam baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>