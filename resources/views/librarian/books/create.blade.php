@extends('layouts.librarian')

@section('title', 'Tambah Buku Baru - E-Lib')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-10">
        <a href="{{ route('librarian.books.index') }}" class="text-indigo-600 font-bold text-sm flex items-center gap-2 mb-4 hover:gap-3 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Katalog
        </a>
        <h1 class="text-4xl font-black text-slate-900 tracking-tight">Tambah Koleksi</h1>
        <p class="text-slate-500 font-medium italic text-sm mt-1">Masukkan data buku baru ke dalam sistem perpustakaan.</p>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">
        <div class="bg-slate-50/50 p-8 border-b border-slate-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
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
                {{-- Judul Buku --}}
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Judul Buku</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="w-full bg-slate-50 border-none rounded-2xl p-4 text-slate-800 font-bold focus:ring-4 focus:ring-indigo-100 transition-all placeholder:text-slate-300 shadow-inner @error('title') ring-2 ring-rose-500 @enderror"
                        required placeholder="Contoh: Filosofi Teras">
                    @error('title')
                    <p class="text-rose-500 text-xs font-bold mt-2 ml-1">* {{ $message }}</p>
                    @enderror
                </div>

                {{-- Penulis --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Penulis</label>
                    <input type="text" name="author" value="{{ old('author') }}"
                        class="w-full bg-slate-50 border-none rounded-2xl p-4 text-slate-800 font-bold focus:ring-4 focus:ring-indigo-100 transition-all placeholder:text-slate-300 shadow-inner @error('author') ring-2 ring-rose-500 @enderror"
                        required placeholder="Nama pengarang...">
                    @error('author')
                    <p class="text-rose-500 text-xs font-bold mt-2 ml-1">* {{ $message }}</p>
                    @enderror
                </div>

                {{-- Penerbit --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Penerbit</label>
                    <input type="text" name="publisher" value="{{ old('publisher') }}"
                        class="w-full bg-slate-50 border-none rounded-2xl p-4 text-slate-800 font-bold focus:ring-4 focus:ring-indigo-100 transition-all placeholder:text-slate-300 shadow-inner @error('publisher') ring-2 ring-rose-500 @enderror"
                        required placeholder="Nama penerbit buku...">
                    @error('publisher')
                    <p class="text-rose-500 text-xs font-bold mt-2 ml-1">* {{ $message }}</p>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Kategori</label>
                    <div class="relative">
                        <select name="category_id"
                            class="w-full bg-slate-50 border-none rounded-2xl p-4 text-slate-800 font-bold focus:ring-4 focus:ring-indigo-100 transition-all appearance-none cursor-pointer shadow-inner @error('category_id') ring-2 ring-rose-500 @enderror"
                            required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    @error('category_id')
                    <p class="text-rose-500 text-xs font-bold mt-2 ml-1">* {{ $message }}</p>
                    @enderror
                </div>

                {{-- Tahun Terbit (FIXED: Name diganti ke 'year' agar sesuai database) --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Tahun Terbit</label>
                    <input type="number" name="year" min="1900" max="2026" value="{{ old('year') }}"
                        class="w-full bg-slate-50 border-none rounded-2xl p-4 text-slate-800 font-black focus:ring-4 focus:ring-indigo-100 transition-all shadow-inner @error('year') ring-2 ring-rose-500 @enderror"
                        required placeholder="2024">
                    @error('year')
                    <p class="text-rose-500 text-xs font-bold mt-2 ml-1">* {{ $message }}</p>
                    @enderror
                </div>

                {{-- Stok Awal --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Stok Awal</label>
                    <input type="number" name="stock" min="1" value="{{ old('stock') }}"
                        class="w-full bg-slate-50 border-none rounded-2xl p-4 text-slate-800 font-black focus:ring-4 focus:ring-indigo-100 transition-all shadow-inner @error('stock') ring-2 ring-rose-500 @enderror"
                        required placeholder="0">
                    @error('stock')
                    <p class="text-rose-500 text-xs font-bold mt-2 ml-1">* {{ $message }}</p>
                    @enderror
                </div>

                {{-- Sampul Buku --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Sampul Buku (Image)</label>
                    <div class="bg-slate-50 rounded-2xl p-2 shadow-inner border-2 border-dashed border-slate-200 @error('book_cover') border-rose-300 @enderror">
                        <input type="file" name="book_cover" id="book_cover" accept="image/*"
                            class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 transition-all cursor-pointer">
                    </div>
                    @error('book_cover')
                    <p class="text-rose-500 text-xs font-bold mt-2 ml-1">* {{ $message }}</p>
                    @enderror

                    {{-- Image Preview Area --}}
                    <div id="preview-area" class="hidden mt-4">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Pratinjau Sampul</p>
                        <div class="w-32 h-44 bg-slate-100 rounded-xl overflow-hidden border border-slate-200">
                            <img id="image-preview" src="#" alt="Preview" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                {{-- Sinopsis / Deskripsi Buku --}}
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Sinopsis / Deskripsi</label>
                    <textarea name="synopsis" rows="6"
                        class="w-full bg-slate-50 border-none rounded-2xl p-4 text-slate-800 font-medium focus:ring-4 focus:ring-indigo-100 transition-all placeholder:text-slate-300 shadow-inner @error('synopsis') ring-2 ring-rose-500 @enderror"
                        placeholder="Tuliskan ringkasan atau sinopsis cerita buku di sini..." required>{{ old('synopsis') }}</textarea>
                    @error('synopsis')
                    <p class="text-rose-500 text-xs font-bold mt-2 ml-1">* {{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-4 mt-12 pt-8 border-t border-slate-50">
                <a href="{{ route('librarian.books.index') }}"
                    class="order-2 sm:order-1 px-8 py-4 text-slate-400 font-bold text-sm hover:text-slate-600 transition-colors text-center">
                    Batal
                </a>
                <button type="submit"
                    class="order-1 sm:order-2 bg-indigo-600 hover:bg-indigo-700 text-white px-10 py-4 rounded-2xl font-black text-sm transition-all shadow-xl shadow-indigo-100 hover:-translate-y-1 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Koleksi
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Script for Image Preview --}}
<script>
    document.getElementById('book_cover').onchange = function(evt) {
        const [file] = this.files;
        if (file) {
            const previewArea = document.getElementById('preview-area');
            const imagePreview = document.getElementById('image-preview');

            imagePreview.src = URL.createObjectURL(file);
            previewArea.classList.remove('hidden');
        }
    }
</script>
@endsection