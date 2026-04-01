@extends('layouts.admin')

@section('title', 'Dashboard')

@section('nav_icon_bg', 'bg-indigo-600')
@section('nav_icon')
    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
@endsection

@section('content')
    <div class="mb-12">
        <h1 class="text-4xl font-black text-slate-900 tracking-tight">Halo, {{ explode(' ', auth()->user()->name)[0] }}! 👋</h1>
        <p class="text-slate-500 mt-2 font-medium italic">Status sistem: <span class="text-emerald-500 font-bold uppercase text-[10px] tracking-widest ml-1 bg-emerald-50 px-2 py-1 rounded-md not-italic">Optimal</span></p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
        @php
            $stats = [
                ['label' => 'Total Pengguna', 'value' => $data['total_user'], 'color' => 'rose', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                ['label' => 'Koleksi Buku', 'value' => $data['total_buku'], 'color' => 'indigo', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                ['label' => 'Sedang Dipinjam', 'value' => $data['total_sedang_dipinjam'], 'color' => 'emerald', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z'],
                ['label' => 'Kategori Buku', 'value' => $data['total_kategori'], 'color' => 'amber', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
            ];
        @endphp

        @foreach($stats as $s)
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/40 hover:-translate-y-2 transition-transform duration-300">
            <div class="w-12 h-12 bg-{{$s['color']}}-50 text-{{$s['color']}}-600 rounded-2xl flex items-center justify-center mb-6">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{$s['icon']}}"></path></svg>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{$s['label']}}</p>
            <p class="text-3xl font-black text-slate-800 mt-1">{{$s['value']}}</p>
        </div>
        @endforeach
    </div>

    <h2 class="text-xl font-black text-slate-800 mb-8 flex items-center gap-3 uppercase tracking-tighter">
        Navigasi Panel Utama <span class="h-[2px] flex-1 bg-slate-100 rounded-full"></span>
    </h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <a href="{{ route('user.dashboard') }}" class="group bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-xl hover:border-indigo-200 hover:-translate-y-2 transition-all duration-300 overflow-hidden relative">
            <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24 font-bold"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <h3 class="text-xl font-black text-slate-800 group-hover:text-indigo-600 transition-colors">Portal Katalog</h3>
            <p class="text-slate-500 mt-2 text-sm font-medium opacity-80 leading-relaxed">Lihat koleksi buku sebagai siswa/user.</p>
        </a>

        <a href="{{ route('librarian.dashboard') }}" class="group bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-xl hover:border-emerald-200 hover:-translate-y-2 transition-all duration-300 overflow-hidden relative">
            <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24 font-bold"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </div>
            <h3 class="text-xl font-black text-slate-800 group-hover:text-emerald-600 transition-colors">Portal Petugas</h3>
            <p class="text-slate-500 mt-2 text-sm font-medium opacity-80 leading-relaxed">Kelola sirkulasi buku dan transaksi.</p>
        </a>

        <a href="{{ route('admin.users.index') }}" class="group bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-xl hover:border-rose-200 hover:-translate-y-2 transition-all duration-300 overflow-hidden relative">
            <div class="w-16 h-16 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24 font-bold"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <h3 class="text-xl font-black text-slate-800 group-hover:text-rose-600 transition-colors">Kelola User</h3>
            <p class="text-slate-500 mt-2 text-sm font-medium opacity-80 leading-relaxed">Ubah role atau hapus akses pengguna.</p>
        </a>
    </div>
@endsection