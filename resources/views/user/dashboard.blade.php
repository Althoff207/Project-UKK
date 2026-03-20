<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buku - ALPUS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <nav class="bg-white shadow-sm sticky top-0 z-10 mb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center gap-4">
                <span class="text-2xl font-extrabold text-indigo-600 tracking-tight">ALPUS</span>
                
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
            <h1 class="text-3xl font-bold text-gray-900">Katalog Buku</h1>
            <p class="text-gray-500 mt-1">Pilih buku yang ingin Anda pinjam hari ini.</p>
        </div>

        <div id="notification-area">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded shadow-sm flex justify-between items-center transition-all duration-500">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-800 rounded shadow-sm flex justify-between items-center transition-all duration-500">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif
        </div>

        <div class="mb-8 flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
            <a href="{{ route('user.dashboard') }}" 
               class="px-5 py-2 rounded-full text-sm font-medium transition {{ !request('category_id') ? 'bg-indigo-600 text-white shadow-md' : 'bg-white text-gray-600 border hover:bg-gray-50' }}">
                Semua Buku
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('user.dashboard', ['category_id' => $cat->id]) }}" 
                   class="px-5 py-2 rounded-full text-sm font-medium whitespace-nowrap transition {{ request('category_id') == $cat->id ? 'bg-indigo-600 text-white shadow-md' : 'bg-white text-gray-600 border hover:bg-gray-50' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
            @forelse($books as $book)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden group">
                    <div class="relative aspect-[3/4] bg-gray-100 overflow-hidden">
                        @if($book->book_cover)
                            <img src="{{ asset('storage/' . $book->book_cover) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="flex flex-col items-center justify-center h-full text-gray-400">
                                <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                <span class="text-xs italic">No Cover</span>
                            </div>
                        @endif
                        <div class="absolute top-3 left-3">
                            <span class="bg-white/90 backdrop-blur px-2 py-1 rounded-md text-[10px] font-bold text-indigo-600 uppercase shadow-sm">
                                {{ $book->category->name ?? 'Umum' }}
                            </span>
                        </div>
                    </div>

                    <div class="p-5 flex-grow flex flex-col">
                        <h3 class="text-lg font-bold text-gray-900 leading-snug mb-1 line-clamp-2">{{ $book->title }}</h3>
                        <p class="text-sm text-gray-500 mb-4 italic">Oleh: {{ $book->author }}</p>
                        
                        <div class="mt-auto">
                            <div class="flex justify-between items-center mb-4 text-sm">
                                <span class="text-gray-400">Tersedia:</span>
                                <span class="font-bold {{ $book->stock > 0 ? 'text-green-600' : 'text-red-500' }}">
                                    {{ $book->stock }} Eks
                                </span>
                            </div>

                            <form action="{{ route('borrow.store', $book->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-full py-2.5 rounded-xl font-bold text-sm transition-all {{ $book->stock > 0 ? 'bg-indigo-600 text-white hover:bg-indigo-700 shadow-indigo-200 shadow-lg' : 'bg-gray-100 text-gray-400 cursor-not-allowed' }}"
                                        {{ $book->stock <= 0 ? 'disabled' : '' }}>
                                    {{ $book->stock > 0 ? 'Pinjam Sekarang' : 'Stok Habis' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <p class="text-gray-400 text-lg">Tidak ada buku di kategori ini.</p>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        setTimeout(function() {
            const notification = document.getElementById('notification-area');
            if (notification) {
                notification.style.opacity = '0';
                setTimeout(() => notification.innerHTML = '', 500);
            }
        }, 3000); // Hilang setelah 3 detik
    </script>

</body>
</html>