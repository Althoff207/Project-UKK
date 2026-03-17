<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pinjam - E-Lib</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <nav class="bg-white shadow-sm sticky top-0 z-10 mb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center gap-4">
                <span class="text-2xl font-extrabold text-indigo-600 tracking-tight">E-LIB</span>
                
                {{-- Tombol Khusus Admin agar bisa balik ke dashboard utama --}}
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="ml-2 bg-red-600 hover:bg-red-700 text-white text-[10px] px-3 py-1 rounded-full font-bold uppercase tracking-wider transition-all">
                        Admin Mode
                    </a>
                @endif
            </div>

            <div class="flex items-center gap-6">
                <a href="{{ route('user.dashboard') }}" class="text-sm font-medium {{ request()->routeIs('user.dashboard') ? 'text-indigo-600' : 'text-gray-500 hover:text-indigo-600' }}">Katalog</a>
                <a href="{{ route('user.history') }}" class="text-sm font-medium {{ request()->routeIs('user.history') ? 'text-indigo-600' : 'text-gray-500 hover:text-indigo-600' }}">Riwayat</a>
                
                <div class="h-6 w-px bg-gray-200"></div>
                
                <div class="flex flex-col text-right">
                    <span class="text-sm text-gray-800 font-bold leading-none">{{ auth()->user()->name }}</span>
                    <span class="text-[10px] text-gray-400 uppercase tracking-tighter">{{ auth()->user()->role }}</span>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm font-bold text-red-500 hover:text-red-700 transition">Keluar</button>
                </form>
            </div>
        </div>
    </div>
</nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Riwayat Peminjaman</h1>
            <p class="text-gray-500 mt-1">Pantau status buku yang Anda pinjam di sini.</p>
        </div>

        <div class="bg-white shadow-sm border border-gray-100 rounded-2xl overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Buku</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Tanggal Pinjam</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Batas Kembali</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($histories as $history)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-5">
                                <div class="flex items-center">
                                    <div class="h-10 w-8 bg-gray-200 rounded flex-shrink-0 overflow-hidden mr-3">
                                        @if($history->book->book_cover)
                                            <img src="{{ asset('storage/' . $history->book->book_cover) }}" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <span class="font-bold text-gray-800">{{ $history->book->title }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-gray-600">
                                {{ \Carbon\Carbon::parse($history->borrow_date)->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-6 py-5 text-gray-600 font-medium">
                                {{ \Carbon\Carbon::parse($history->return_due_date)->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-6 py-5 text-center">
                                @if($history->status == 'pending')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-[11px] font-bold uppercase tracking-wide">Menunggu</span>
                                @elseif($history->status == 'approved')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[11px] font-bold uppercase tracking-wide">Dipinjam</span>
                                @elseif($history->status == 'rejected')
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-[11px] font-bold uppercase tracking-wide">Ditolak</span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-[11px] font-bold uppercase tracking-wide">Kembali</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic">
                                Anda belum pernah meminjam buku.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>