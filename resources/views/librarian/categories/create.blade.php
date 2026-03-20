@extends('layouts.librarian')

@section('title', 'Tambah Kategori - E-Lib')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-10">
        <a href="{{ route('librarian.categories.index') }}" class="text-rose-600 font-bold text-sm flex items-center gap-2 mb-4 hover:gap-3 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Kategori
        </a>
        <h1 class="text-4xl font-black text-slate-900 tracking-tight">Kategori Baru</h1>
        <p class="text-slate-500 font-medium italic text-sm mt-1">Buat klasifikasi baru untuk mengorganisir koleksi buku.</p>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">
        <div class="bg-slate-50/50 p-8 border-b border-slate-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-rose-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-rose-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                </div>
                <div>
                    <h3 class="font-black text-slate-800 uppercase tracking-widest text-xs">Entri Klasifikasi</h3>
                    <p class="text-slate-400 text-[10px] font-bold italic uppercase tracking-tighter">Gunakan nama yang deskriptif dan singkat</p>
                </div>
            </div>
        </div>

        <form action="{{ route('librarian.categories.store') }}" method="POST" class="p-10 space-y-8">
            @csrf

            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Nama Kategori</label>
                    <input type="text" name="name" 
                        class="w-full bg-slate-50 border-none rounded-2xl p-4 text-slate-800 font-bold focus:ring-4 focus:ring-rose-100 transition-all placeholder:text-slate-300 shadow-inner" 
                        required placeholder="Contoh: Pengembangan Diri, Teknologi, Fiksi...">
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-4 mt-12 pt-8 border-t border-slate-50">
                <a href="{{ route('librarian.categories.index') }}" 
                    class="order-2 sm:order-1 px-8 py-4 text-slate-400 font-bold text-sm hover:text-slate-600 transition-colors text-center">
                    Batal
                </a>
                <button type="submit" 
                    class="order-1 sm:order-2 bg-rose-500 hover:bg-rose-600 text-white px-10 py-4 rounded-2xl font-black text-sm transition-all shadow-xl shadow-rose-100 hover:-translate-y-1 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>
</div>
@endsection