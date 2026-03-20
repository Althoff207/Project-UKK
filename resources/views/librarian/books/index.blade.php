@extends('layouts.librarian')

@section('title', 'Kelola Buku - E-Lib')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-none">Koleksi Buku</h1>
            <p class="text-slate-500 font-medium italic text-sm mt-3 flex items-center gap-2">
                <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></span>
                Manajemen inventaris pustaka real-time.
            </p>
        </div>
        <a href="{{ route('librarian.books.create') }}" class="group bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-4 rounded-2xl font-bold transition-all shadow-xl shadow-indigo-200 flex items-center gap-3 hover:-translate-y-1">
            <div class="bg-indigo-500 p-1 rounded-lg group-hover:rotate-90 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
            </div>
            Tambah Buku Baru
        </a>
    </div>

    {{-- Stats Mini (Opsional, untuk mempercantik) --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Koleksi</p>
                <p class="text-xl font-black text-slate-800">{{ $books->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Main Table Card --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-2xl shadow-slate-200/50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="p-6 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] text-center w-24">Cover</th>
                        <th class="p-6 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Informasi Buku</th>
                        <th class="p-6 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Kategori</th>
                        <th class="p-6 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Status Stok</th>
                        <th class="p-6 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Manajemen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($books as $b)
                    <tr class="hover:bg-indigo-50/30 transition-all group">
                        <td class="p-6">
                            <div class="relative w-16 h-24 mx-auto group-hover:scale-110 transition-transform duration-300">
                                @if($b->book_cover)
                                    <img src="{{ asset('storage/'.$b->book_cover) }}" class="w-full h-full object-cover rounded-xl shadow-lg ring-4 ring-white">
                                @else
                                    <div class="w-full h-full bg-slate-100 rounded-xl flex items-center justify-center text-slate-300 italic text-[10px] text-center p-2 border-2 border-dashed border-slate-200">No Cover</div>
                                @endif
                            </div>
                        </td>
                        <td class="p-6">
                            <div class="flex flex-col">
                                <span class="text-lg font-black text-slate-800 leading-none group-hover:text-indigo-600 transition-colors">{{ $b->title }}</span>
                                <span class="text-slate-400 text-sm font-medium mt-2 italic">Oleh: <span class="text-slate-600 not-italic font-bold">{{ $b->author }}</span></span>
                                <code class="text-[10px] font-bold text-indigo-400 mt-2 tracking-widest bg-indigo-50 w-fit px-2 py-0.5 rounded">ID: #BK-{{ str_pad($b->id, 4, '0', STR_PAD_LEFT) }}</code>
                            </div>
                        </td>
                        <td class="p-6">
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-black bg-white border border-slate-100 text-slate-600 shadow-sm group-hover:border-indigo-200 group-hover:text-indigo-600 transition-all uppercase tracking-tighter">
                                {{ $b->category->name }}
                            </span>
                        </td>
                        <td class="p-6 text-center">
                            <div class="flex flex-col items-center">
                                <span class="text-2xl font-black {{ $b->stock > 0 ? 'text-slate-800' : 'text-rose-500' }}">{{ $b->stock }}</span>
                                <span class="text-[9px] font-black uppercase tracking-widest {{ $b->stock > 5 ? 'text-emerald-500' : ($b->stock > 0 ? 'text-amber-500' : 'text-rose-500') }}">
                                    {{ $b->stock > 5 ? 'Tersedia' : ($b->stock > 0 ? 'Hampir Habis' : 'Kosong') }}
                                </span>
                            </div>
                        </td>
                        <td class="p-6 text-right">
                            <div class="flex justify-end items-center gap-2">
                                <a href="{{ route('librarian.books.edit', $b->id) }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all shadow-sm" title="Edit Buku">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <button type="button" class="w-10 h-10 flex items-center justify-center rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all shadow-sm btn-delete" data-id="{{ $b->id }}" data-title="{{ $b->title }}" title="Hapus Buku">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                                <form id="delete-form-{{ $b->id }}" action="{{ route('librarian.books.destroy', $b->id) }}" method="POST" class="hidden">
                                    @csrf @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-slate-50 text-slate-300 rounded-[2rem] flex items-center justify-center mb-4">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                                <h3 class="text-lg font-black text-slate-400">Belum ada koleksi buku</h3>
                                <p class="text-slate-400 text-sm italic mt-1 font-medium">Klik tombol tambah buku di atas untuk memulai.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- SweetAlert2 JS --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Notifikasi Berhasil (Jika ada session success)
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            showConfirmButton: false,
            timer: 2000,
            background: '#ffffff',
            iconColor: '#6366f1',
            customClass: {
                title: 'font-black text-slate-800',
                popup: 'rounded-[2rem] border-none shadow-2xl'
            }
        });
    @endif

    // Konfirmasi Hapus
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const title = this.getAttribute('data-title');

            Swal.fire({
                title: 'Hapus Koleksi?',
                text: `Anda akan menghapus buku "${title}". Tindakan ini tidak dapat dibatalkan!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Hapus Permanen',
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
                    document.getElementById(`delete-form-${id}`).submit();
                }
            });
        });
    });
</script>
@endsection