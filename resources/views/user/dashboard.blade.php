@extends('layouts.user')

@section('title', 'Katalog Buku - ALPUS')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    {{-- Header --}}
    <div class="mb-12">
        <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-none">Katalog Buku</h1>
        <p class="text-slate-500 font-medium italic text-sm mt-3 flex items-center gap-2">
            <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></span>
            Pilih buku yang ingin Anda pinjam hari ini.
        </p>
    </div>

    {{-- Kategori --}}
    <div class="mb-10 flex items-center gap-4 overflow-x-auto pb-4 scrollbar-hide">
        
        <a href="{{ route('user.dashboard') }}" 
           class="shrink-0 px-7 py-3 rounded-2xl text-[11px] font-black uppercase tracking-wider transition-all duration-200 active:scale-95 flex items-center justify-center
           {{ !request('category_id') 
                ? 'bg-slate-900 text-white shadow-lg shadow-slate-900/20' 
                : 'bg-white text-slate-500 border border-slate-100 hover:text-indigo-600 hover:border-indigo-100 shadow-sm shadow-slate-100/50' }}">
            Semua Koleksi
        </a>

        @foreach($categories as $cat)
            <a href="{{ route('user.dashboard', ['category_id' => $cat->id]) }}" 
               class="shrink-0 px-7 py-3 rounded-2xl text-[11px] font-black uppercase tracking-wider whitespace-nowrap transition-all duration-200 active:scale-95 flex items-center justify-center
               {{ request('category_id') == $cat->id 
                    ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' 
                    : 'bg-white text-slate-500 border border-slate-100 hover:text-indigo-600 hover:border-indigo-100 shadow-sm shadow-slate-100/50' }}">
                {{ $cat->name }}
            </a>
        @endforeach
        
    </div>

    {{-- Grid Buku --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 mb-20">
        @forelse($books as $book)
            <div class="group bg-white rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-slate-200 transition-all duration-500 flex flex-col overflow-hidden hover:-translate-y-2">
                
                {{-- Cover Area (Bisa diklik ke Detail) --}}
                <a href="{{ route('user.books.detail', $book->id) }}" class="relative aspect-[3/4] overflow-hidden m-3 rounded-[1.8rem] bg-slate-50 block">
                    @if($book->book_cover)
                        <img src="{{ asset('storage/' . $book->book_cover) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-300">
                            <svg class="w-16 h-16 mb-2 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                    @endif

                    <div class="absolute top-4 left-4">
                        <span class="bg-white/90 backdrop-blur-md px-4 py-1.5 rounded-xl text-[9px] font-black text-indigo-600 uppercase tracking-widest shadow-sm">
                            {{ $book->category->name ?? 'Umum' }}
                        </span>
                    </div>
                </a>

                <div class="px-7 pb-7 pt-2 flex-grow flex flex-col">
                    {{-- Judul Buku (Bisa diklik ke Detail) --}}
                    <a href="{{ route('user.books.detail', $book->id) }}">
                        <h3 class="text-xl font-black text-slate-800 leading-tight mb-2 line-clamp-2 hover:text-indigo-600 transition-colors">{{ $book->title }}</h3>
                    </a>
                    <p class="text-sm text-slate-400 font-bold italic mb-6">Oleh: {{ $book->author }}</p>
                    
                    <div class="mt-auto">
                        <div class="flex justify-between items-center mb-5 bg-slate-50 px-4 py-2 rounded-xl text-sm">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tersedia</span>
                            <span class="font-black {{ $book->stock > 0 ? 'text-indigo-600' : 'text-rose-500' }}">
                                {{ $book->stock }} Eks
                            </span>
                        </div>

                        {{-- Tombol dengan Trigger SweetAlert --}}
                        @if($book->stock > 0)
                            <button type="button" 
                                    class="btn-borrow-confirm w-full py-4 rounded-2xl font-black text-sm transition-all bg-indigo-600 text-white hover:bg-slate-900 shadow-xl shadow-indigo-100 active:scale-95"
                                    data-id="{{ $book->id }}"
                                    data-title="{{ $book->title }}">
                                Pinjam Sekarang
                            </button>

                            <form id="borrow-form-{{ $book->id }}" action="{{ route('user.borrow.store', $book->id) }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        @else
                            <button type="button" class="w-full py-4 rounded-2xl font-black text-sm bg-slate-100 text-slate-300 cursor-not-allowed" disabled>
                                Stok Habis
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-32 text-center bg-white rounded-[3rem] border-2 border-dashed border-slate-100">
                <p class="text-slate-400 font-bold italic">Tidak ada koleksi buku di kategori ini.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- SCRIPT SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // 1. Handling Notifikasi dari Controller
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            showConfirmButton: false,
            timer: 2500,
            background: '#ffffff',
            iconColor: '#4f46e5',
            customClass: {
                title: 'font-black text-slate-800',
                popup: 'rounded-[2.5rem] border-none shadow-2xl'
            }
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: '{{ session("error") }}',
            confirmButtonColor: '#f43f5e',
            background: '#ffffff',
            customClass: {
                title: 'font-black text-slate-800',
                popup: 'rounded-[2.5rem] border-none shadow-2xl',
                confirmButton: 'rounded-xl font-bold px-6 py-3'
            }
        });
    @endif

    // 2. Konfirmasi Pinjam Buku
    document.querySelectorAll('.btn-borrow-confirm').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const title = this.getAttribute('data-title');

            Swal.fire({
                title: 'Pinjam Buku Ini?',
                text: `Konfirmasi pengajuan pinjam untuk buku "${title}".`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Pinjam',
                cancelButtonText: 'Batal',
                background: '#ffffff',
                reverseButtons: true,
                customClass: {
                    title: 'font-black text-slate-800',
                    popup: 'rounded-[2.5rem] border-none shadow-2xl',
                    confirmButton: 'rounded-xl font-bold px-6 py-3',
                    cancelButton: 'rounded-xl font-bold px-6 py-3'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan loading & sembunyikan tombol agar bersih
                    Swal.fire({
                        title: 'Memproses...',
                        allowOutsideClick: false,
                        showConfirmButton: false, 
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    document.getElementById(`borrow-form-${id}`).submit();
                }
            });
        });
    });
</script>
@endsection