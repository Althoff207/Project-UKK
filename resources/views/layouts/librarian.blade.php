<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Panel Petugas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50">
    <nav class="bg-indigo-700 shadow-2xl mb-10 border-b border-indigo-800/50 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center text-white">
            <div class="flex items-center gap-8">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center font-black italic shadow-inner">L</div>
                    <span class="font-black text-xl tracking-tighter uppercase">ALPUS <span class="text-indigo-200">STAFF</span></span>
                </div>

                <div class="hidden md:flex items-center gap-1 bg-indigo-800/40 p-1 rounded-2xl border border-white/10">
                    <a href="{{ route('librarian.dashboard') }}" class="px-5 py-2 rounded-xl text-xs font-bold uppercase tracking-widest transition-all {{ request()->routeIs('librarian.dashboard') ? 'bg-white text-indigo-700 shadow-lg' : 'hover:bg-white/10' }}">Dashboard</a>
                    <a href="{{ route('librarian.approval') }}" class="px-5 py-2 rounded-xl text-xs font-bold uppercase tracking-widest transition-all {{ request()->routeIs('librarian.approval') ? 'bg-white text-indigo-700 shadow-lg' : 'hover:bg-white/10' }}">Persetujuan</a>
                    <a href="{{ route('librarian.returns') }}" class="px-5 py-2 rounded-xl text-xs font-bold uppercase tracking-widest transition-all {{ request()->routeIs('librarian.returns') ? 'bg-white text-indigo-700 shadow-lg' : 'hover:bg-white/10' }}">Pengembalian</a>
                    <a href="{{ route('librarian.books.index') }}" class="px-5 py-2 rounded-xl text-xs font-bold uppercase tracking-widest transition-all {{ request()->is('librarian/books*') ? 'bg-white text-indigo-700 shadow-lg' : 'hover:bg-white/10' }}">Buku</a>
                    <a href="{{ route('librarian.categories.index') }}" class="px-5 py-2 rounded-xl text-xs font-bold uppercase tracking-widest transition-all {{ request()->is('librarian/categories*') ? 'bg-white text-indigo-700 shadow-lg' : 'hover:bg-white/10' }}">Kategori</a>
                </div>
            </div>

            <div class="flex items-center gap-6">
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="hidden lg:block bg-rose-600 hover:bg-rose-700 text-white text-[10px] px-4 py-2 rounded-xl font-black uppercase tracking-widest transition-all shadow-lg shadow-rose-900/20">
                        Admin Panel
                    </a>
                @endif
                
                <div class="flex items-center gap-3 pl-6 border-l border-white/10">
                    <div class="text-right hidden sm:block">
                        <p class="text-[10px] font-black uppercase tracking-widest text-indigo-200 leading-none mb-1">Petugas</p>
                        <p class="text-xs font-bold leading-none">{{ auth()->user()->name }}</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="p-2.5 bg-white/10 hover:bg-rose-500 rounded-xl transition-all group">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 pb-20">
        @yield('content')
    </main>

    @yield('scripts')
</body>
</html>