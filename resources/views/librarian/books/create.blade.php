@extends('layouts.librarian')

@section('title', 'Tambah Buku Baru - E-Lib')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-10">
        <a href="{{ route('librarian.books.index') }}" class="text-indigo-600 font-bold text-sm flex items-center gap-2 mb-4 hover:gap-3 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Katalog
        </a>
        <h1 class="text-4xl font-black text-slate-900 tracking-tight">Tambah Koleksi</h1>
        <p class="text-slate-500 font-medium italic text-sm mt-1">Masukkan data buku baru ke dalam sistem perpustakaan.</p>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">
        <div class="bg-slate-50/50 p-8 border-b border-slate-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                </div>
                <div>
                    <h3 class="font-black text-slate-800 uppercase tracking-widest text-xs">Entri Buku Baru</h3>
                    <p class="text-slate-400 text-[10px] font-bold italic uppercase tracking-tighter">Pastikan data yang dimasukkan sudah valid</p>
                </div>
            </div>
        </div>

        <form action="{{ route('librarian.books.store') }}" method="POST" enctype="multipart/form-data" class="p-10 space-y-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Judul Buku</label>
                    <input type="text" name="title" 
                        class="w-full bg-slate-50 border-none rounded-2xl p-4 text-slate-800 font-bold focus:ring-4 focus:ring-indigo-100 transition-all placeholder:text-slate-300 shadow-inner" 
                        required placeholder="Contoh: Filosofi Teras">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Penulis</label>
                    <input type="text" name="author" 
                        class="w-full bg-slate-50 border-none rounded-2xl p-4 text-slate-800 font-bold focus:ring-4 focus:ring-indigo-100 transition-all placeholder:text-slate-300 shadow-inner" 
                        required placeholder="Nama pengarang...">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Kategori</label>
                    <div class="relative">
                        <select name="category_id" 
                            class="w-full bg-slate-50 border-none rounded-2xl p-4 text-slate-800 font-bold focus:ring-4 focus:ring-indigo-100 transition-all appearance-none cursor-pointer shadow-inner" 
                            required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Stok Awal</label>
                    <input type="number" name="stock" min="1"
                        class="w-full bg-slate-50 border-none rounded-2xl p-4 text-slate-800 font-black focus:ring-4 focus:ring-indigo-100 transition-all shadow-inner" 
                        required placeholder="0">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Sampul Buku (Image)</label>
                    <div class="bg-slate-50 rounded-2xl p-2 shadow-inner border-2 border-dashed border-slate-200">
                        <input type="file" name="book_cover" 
                            class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 transition-all cursor-pointer">
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-4 mt-12 pt-8 border-t border-slate-50">
                <a href="{{ route('librarian.books.index') }}" 
                    class="order-2 sm:order-1 px-8 py-4 text-slate-400 font-bold text-sm hover:text-slate-600 transition-colors text-center">
                    Batal
                </a>
                <button type="submit" 
                    class="order-1 sm:order-2 bg-indigo-600 hover:bg-indigo-700 text-white px-10 py-4 rounded-2xl font-black text-sm transition-all shadow-xl shadow-indigo-100 hover:-translate-y-1 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Koleksi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection