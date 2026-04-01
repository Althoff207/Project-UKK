@extends('layouts.librarian')

@section('title', 'Edit Buku - E-Lib')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-10">
        <a href="{{ route('librarian.books.index') }}" class="text-indigo-600 font-bold text-sm flex items-center gap-2 mb-4 hover:gap-3 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Katalog
        </a>
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Edit Detail Buku</h1>
        <p class="text-slate-500 font-medium italic text-sm mt-1">Perbarui informasi koleksi buku perpustakaan.</p>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">
        <div class="bg-slate-50/50 p-8 border-b border-slate-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <div>
                    <h3 class="font-black text-slate-800 uppercase tracking-widest text-xs">Formulir Pembaruan</h3>
                    <p class="text-slate-400 text-xs font-bold italic">ID Buku: #BK-{{ $book->id }}</p>
                </div>
            </div>
        </div>

        <form action="{{ route('librarian.books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="p-10 space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Judul Buku --}}
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Judul Lengkap</label>
                    <input type="text" name="title" value="{{ old('title', $book->title) }}" 
                        class="w-full bg-slate-50 border-none rounded-2xl p-4 text-slate-800 font-bold focus:ring-4 focus:ring-indigo-100 transition-all placeholder:text-slate-300 shadow-inner @error('title') ring-2 ring-rose-500 @enderror" 
                        required placeholder="Masukkan judul buku...">
                    @error('title')
                        <p class="text-rose-500 text-xs font-bold mt-2 ml-1">* {{ $message }}</p>
                    @enderror
                </div>

                {{-- Penulis --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Penulis / Nama Pengarang</label>
                    <input type="text" name="author" value="{{ old('author', $book->author) }}" 
                        class="w-full bg-slate-50 border-none rounded-2xl p-4 text-slate-800 font-bold focus:ring-4 focus:ring-indigo-100 transition-all placeholder:text-slate-300 shadow-inner @error('author') ring-2 ring-rose-500 @enderror" 
                        required placeholder="Nama penulis...">
                    @error('author')
                        <p class="text-rose-500 text-xs font-bold mt-2 ml-1">* {{ $message }}</p>
                    @enderror
                </div>

                {{-- Penerbit --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Penerbit</label>
                    <input type="text" name="publisher" value="{{ old('publisher', $book->publisher) }}" 
                        class="w-full bg-slate-50 border-none rounded-2xl p-4 text-slate-800 font-bold focus:ring-4 focus:ring-indigo-100 transition-all placeholder:text-slate-300 shadow-inner @error('publisher') ring-2 ring-rose-500 @enderror" 
                        required placeholder="Nama penerbit...">
                    @error('publisher')
                        <p class="text-rose-500 text-xs font-bold mt-2 ml-1">* {{ $message }}</p>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Kategori Genre</label>
                    <div class="relative">
                        <select name="category_id" 
                            class="w-full bg-slate-50 border-none rounded-2xl p-4 text-slate-800 font-bold focus:ring-4 focus:ring-indigo-100 transition-all appearance-none cursor-pointer shadow-inner @error('category_id') ring-2 ring-rose-500 @enderror" 
                            required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $book->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                    @error('category_id')
                        <p class="text-rose-500 text-xs font-bold mt-2 ml-1">* {{ $message }}</p>
                    @enderror
                </div>

                {{-- Tahun Terbit (FIXED: Name diganti ke 'year' agar sinkron dengan database) --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Tahun Terbit</label>
                    <input type="number" name="year" min="1900" max="2026" value="{{ old('year', $book->year) }}" 
                        class="w-full bg-slate-50 border-none rounded-2xl p-4 text-slate-800 font-black focus:ring-4 focus:ring-indigo-100 transition-all shadow-inner @error('year') ring-2 ring-rose-500 @enderror" 
                        required placeholder="Contoh: 2024">
                    @error('year')
                        <p class="text-rose-500 text-xs font-bold mt-2 ml-1">* {{ $message }}</p>
                    @enderror
                </div>

                {{-- Jumlah Stok --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Jumlah Stok</label>
                    <input type="number" name="stock" value="{{ old('stock', $book->stock) }}" 
                        class="w-full bg-slate-50 border-none rounded-2xl p-4 text-slate-800 font-black focus:ring-4 focus:ring-indigo-100 transition-all shadow-inner @error('stock') ring-2 ring-rose-500 @enderror" 
                        required min="0">
                    @error('stock')
                        <p class="text-rose-500 text-xs font-bold mt-2 ml-1">* {{ $message }}</p>
                    @enderror
                </div>

                {{-- Upload Sampul Buku --}}
                <div class="md:col-span-2 flex flex-col sm:flex-row gap-6 items-center bg-slate-50/50 p-6 rounded-[2rem] border-2 border-dashed border-slate-100">
                    <div class="relative group">
                        <div class="w-24 h-32 bg-white rounded-xl shadow-lg overflow-hidden border-4 border-white">
                            @if($book->book_cover)
                                <img id="image-preview" src="{{ asset('storage/'.$book->book_cover) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                            @else
                                <div id="no-cover-text" class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300 italic text-[10px]">No Cover</div>
                                <img id="image-preview" class="w-full h-full object-cover group-hover:scale-110 transition-transform hidden">
                            @endif
                        </div>
                        <div class="absolute -bottom-2 -right-2 bg-indigo-600 text-white p-1.5 rounded-lg shadow-lg">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </div>
                    
                    <div class="flex-1 text-center sm:text-left">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Perbarui Cover Buku</label>
                        <input type="file" name="book_cover" id="book_cover" accept="image/*"
                            class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 transition-all cursor-pointer">
                        <p class="text-[10px] text-slate-400 mt-2 italic font-medium">*Kosongkan jika tidak ingin mengubah sampul buku.</p>
                        @error('book_cover')
                            <p class="text-rose-500 text-xs font-bold mt-2 ml-1">* {{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Sinopsis / Deskripsi --}}
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Sinopsis / Deskripsi</label>
                    <textarea name="synopsis" rows="6" 
                        class="w-full bg-slate-50 border-none rounded-2xl p-4 text-slate-800 font-medium focus:ring-4 focus:ring-indigo-100 transition-all placeholder:text-slate-300 shadow-inner @error('synopsis') ring-2 ring-rose-500 @enderror" 
                        placeholder="Tuliskan ringkasan cerita buku di sini..." required>{{ old('synopsis', $book->synopsis) }}</textarea>
                    @error('synopsis')
                        <p class="text-rose-500 text-xs font-bold mt-2 ml-1">* {{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-4 mt-12 pt-8 border-t border-slate-50">
                <a href="{{ route('librarian.books.index') }}" 
                    class="order-2 sm:order-1 px-8 py-4 text-slate-400 font-bold text-sm hover:text-slate-600 transition-colors text-center">
                    Batalkan Perubahan
                </a>
                <button type="submit" 
                    class="order-1 sm:order-2 bg-indigo-600 hover:bg-indigo-700 text-white px-10 py-4 rounded-2xl font-black text-sm transition-all shadow-xl shadow-indigo-100 hover:-translate-y-1 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Script for Live Image Preview --}}
<script>
    document.getElementById('book_cover').onchange = function (evt) {
        const [file] = this.files;
        if (file) {
            const imagePreview = document.getElementById('image-preview');
            const noCoverText = document.getElementById('no-cover-text');
            
            imagePreview.src = URL.createObjectURL(file);
            imagePreview.classList.remove('hidden');
            if(noCoverText) {
                noCoverText.classList.add('hidden');
            }
        }
    }
</script>
@endsection