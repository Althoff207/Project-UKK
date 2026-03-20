@extends('layouts.librarian')

@section('title', 'Dashboard Petugas')

@section('content')
    <div class="mb-12">
        <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-none">
            Halo, {{ explode(' ', auth()->user()->name)[0] }}! 👋
        </h1>
        <p class="text-slate-500 mt-3 font-medium italic text-sm">
            Panel kendali perpustakaan: <span class="text-indigo-500 font-bold uppercase text-[10px] tracking-widest ml-1 bg-indigo-50 px-2 py-1 rounded-md not-italic">Update Real-time</span>
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
        @php
            $stats = [
                [
                    'label' => 'Koleksi Buku', 
                    'value' => $data['total_buku'], 
                    'bg' => 'bg-indigo-50', 'text' => 'text-indigo-600', 
                    'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'
                ],
                [
                    'label' => 'Butuh Approval', 
                    'value' => $data['total_pending'], 
                    'bg' => 'bg-amber-50', 'text' => 'text-amber-600', 
                    'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2'
                ],
                [
                    'label' => 'Sedang Dipinjam', 
                    'value' => $data['total_sedang_dipinjam'], 
                    'bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 
                    'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                ],
                [
                    'label' => 'Total Kategori', 
                    'value' => $data['total_kategori'], 
                    'bg' => 'bg-rose-50', 'text' => 'text-rose-600', 
                    'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'
                ],
            ];
        @endphp

        @foreach($stats as $s)
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/40 hover:-translate-y-2 transition-transform duration-300">
            <div class="w-12 h-12 {{ $s['bg'] }} {{ $s['text'] }} rounded-2xl flex items-center justify-center mb-6 shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{$s['icon']}}"></path></svg>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{$s['label']}}</p>
            <p class="text-3xl font-black text-slate-800 mt-1">{{$s['value']}}</p>
        </div>
        @endforeach
    </div>

    <h2 class="text-xl font-black text-slate-800 mb-8 flex items-center gap-3 uppercase tracking-tighter">
        Navigasi Panel Utama <span class="h-[2px] flex-1 bg-slate-100 rounded-full"></span>
    </h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
        {{-- Fixed: Menggunakan librarian.approval --}}
        <a href="{{ route('librarian.approval') }}" class="group bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-xl hover:border-amber-200 hover:-translate-y-2 transition-all duration-300">
            <div class="w-16 h-16 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-inner border border-amber-100">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-xl font-black text-slate-800 group-hover:text-amber-600 transition-colors">Persetujuan</h3>
            <p class="text-slate-500 mt-2 text-sm font-medium opacity-80 leading-relaxed italic">Cek antrean permintaan pinjam.</p>
        </a>

        {{-- Fixed: Menggunakan librarian.returns (SESUAI web.php KAMU) --}}
        <a href="{{ route('librarian.returns') }}" class="group bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-xl hover:border-emerald-200 hover:-translate-y-2 transition-all duration-300">
            <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-inner border border-emerald-100">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            </div>
            <h3 class="text-xl font-black text-slate-800 group-hover:text-emerald-600 transition-colors">Pengembalian</h3>
            <p class="text-slate-500 mt-2 text-sm font-medium opacity-80 leading-relaxed italic">Proses buku yang kembali.</p>
        </a>

        {{-- Fixed: Menggunakan rute resource otomatis --}}
        <a href="{{ route('librarian.books.index') }}" class="group bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-xl hover:border-indigo-200 hover:-translate-y-2 transition-all duration-300">
            <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-inner border border-indigo-100">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <h3 class="text-xl font-black text-slate-800 group-hover:text-indigo-600 transition-colors">Katalog Buku</h3>
            <p class="text-slate-500 mt-2 text-sm font-medium opacity-80 leading-relaxed italic">Manajemen data buku.</p>
        </a>

        <a href="{{ route('librarian.categories.index') }}" class="group bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-xl hover:border-rose-200 hover:-translate-y-2 transition-all duration-300">
            <div class="w-16 h-16 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-inner border border-rose-100">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
            </div>
            <h3 class="text-xl font-black text-slate-800 group-hover:text-rose-600 transition-colors">Kategori</h3>
            <p class="text-slate-500 mt-2 text-sm font-medium opacity-80 leading-relaxed italic">Atur kategori genre buku.</p>
        </a>
    </div>
@endsection