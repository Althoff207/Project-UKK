@extends('layouts.user')

@section('title', $book->title . ' - Detail Buku')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
    
    {{-- Breadcrumb & Back --}}
    <div class="mb-8">
        <a href="{{ route('user.dashboard') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-indigo-600 font-bold transition-colors group">
            <div class="p-2 bg-white border border-slate-200 rounded-xl group-hover:border-indigo-100 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                </svg>
            </div>
            <span class="text-sm italic">Kembali ke Katalog</span>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-12 items-start">
        
        {{-- Cover Section (Left) --}}
        <div class="md:col-span-5 lg:col-span-4">
            <div class="sticky top-8">
                <div class="relative aspect-[3/4] rounded-[3rem] overflow-hidden shadow-2xl shadow-indigo-100 border-8 border-white group">
                    @if($book->book_cover)
                        <img src="{{ asset('storage/' . $book->book_cover) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-slate-100 flex flex-col items-center justify-center text-slate-300">
                            <svg class="w-20 h-20 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                    @endif
                    
                    {{-- Floating Badge --}}
                    <div class="absolute top-6 right-6">
                        <span class="bg-indigo-600 text-white px-5 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-indigo-200">
                            {{ $book->category->name ?? 'Umum' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Info Section (Right) --}}
        <div class="md:col-span-7 lg:col-span-8">
            <div class="mb-8">
                <h1 class="text-5xl font-black text-slate-900 tracking-tight leading-[1.1] mb-4">{{ $book->title }}</h1>
                <div class="flex items-center gap-4 text-slate-400">
                    <p class="font-bold italic text-lg text-indigo-500">Oleh: {{ $book->author }}</p>
                    <span class="w-1.5 h-1.5 bg-slate-200 rounded-full"></span>
                    <p class="font-medium">Penerbit: {{ $book->publisher }}</p>
                </div>
            </div>

            {{-- Quick Stats Card --}}
            <div class="grid grid-cols-3 gap-4 mb-10">
                <div class="bg-slate-50 p-6 rounded-[2rem] border border-slate-100">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Stok Tersedia</p>
                    <p class="text-2xl font-black {{ $book->stock > 0 ? 'text-slate-800' : 'text-rose-500' }}">
                        {{ $book->stock }} <span class="text-xs font-bold text-slate-400 uppercase">Eks</span>
                    </p>
                </div>
                <div class="bg-slate-50 p-6 rounded-[2rem] border border-slate-100">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Tahun Terbit</p>
                    <p class="text-2xl font-black text-slate-800">{{ $book->year ?? '-' }}</p>
                </div>
                <div class="bg-slate-50 p-6 rounded-[2rem] border border-slate-100">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Status Pinjam</p>
                    <p class="text-sm font-black {{ $book->stock > 0 ? 'text-emerald-500' : 'text-rose-500' }} uppercase">
                        {{ $book->stock > 0 ? 'Tersedia' : 'Kosong' }}
                    </p>
                </div>
            </div>

            {{-- Deskripsi/Sinopsis --}}
            <div class="mb-12">
                <h2 class="text-xl font-black text-slate-800 mb-4 flex items-center gap-3">
                    Sinopsis Buku <span class="h-[2px] flex-1 bg-slate-100 rounded-full"></span>
                </h2>
                <div class="prose prose-slate max-w-none">
                    <p class="text-slate-500 leading-relaxed font-medium italic">
                        {{ $book->synopsis ?? 'Tidak ada deskripsi untuk buku ini.' }}
                    </p>
                </div>
            </div>

            {{-- Action Button --}}
            <div class="flex items-center gap-4 p-2 bg-white border border-slate-100 rounded-[2.5rem] shadow-xl shadow-slate-200/50">
                <div class="flex-1 px-6">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Sudah yakin dengan pilihanmu?</p>
                </div>
                
                @if($book->stock > 0)
                    <button type="button" 
                        class="btn-borrow-confirm px-10 py-5 bg-indigo-600 text-white rounded-[2rem] font-black text-sm hover:bg-slate-900 transition-all shadow-xl shadow-indigo-100 active:scale-95"
                        data-id="{{ $book->id }}"
                        data-title="{{ $book->title }}">
                        Ajukan Pinjam Sekarang
                    </button>
                    
                    <form id="borrow-form-{{ $book->id }}" action="{{ route('user.borrow.store', $book->id) }}" method="POST" class="hidden">
                        @csrf
                    </form>
                @else
                    <button type="button" class="px-10 py-5 bg-slate-100 text-slate-300 rounded-[2rem] font-black text-sm cursor-not-allowed" disabled>
                        Stok Tidak Mencukupi
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT SWEETALERT (Sama Seperti di Dashboard) --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelector('.btn-borrow-confirm')?.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const title = this.getAttribute('data-title');

        Swal.fire({
            title: 'Konfirmasi Pinjam',
            text: `Yakin ingin meminjam buku "${title}"?`,
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
                Swal.fire({
                    title: 'Memproses...',
                    didOpen: () => { Swal.showLoading(); }
                });
                document.getElementById(`borrow-form-${id}`).submit();
            }
        });
    });
</script>
@endsection