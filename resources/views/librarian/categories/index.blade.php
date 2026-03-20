@extends('layouts.librarian')

@section('title', 'Manajemen Kategori - E-Lib')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Header Section - Identik dengan Books --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-none">Kategori Buku</h1>
            <p class="text-slate-500 font-medium italic text-sm mt-3 flex items-center gap-2">
                <span class="w-2 h-2 bg-rose-500 rounded-full animate-pulse"></span>
                Klasifikasi genre untuk memudahkan pencarian koleksi.
            </p>
        </div>
        <a href="{{ route('librarian.categories.create') }}" class="group bg-rose-500 hover:bg-rose-600 text-white px-8 py-4 rounded-2xl font-bold transition-all shadow-xl shadow-rose-200 flex items-center gap-3 hover:-translate-y-1">
            <div class="bg-rose-400 p-1 rounded-lg group-hover:rotate-90 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            Tambah Kategori
        </a>
    </div>

    {{-- Stats Mini - Identik dengan Books --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-10 h-10 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Genre</p>
                <p class="text-xl font-black text-slate-800">{{ $categories->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Main Table Card - Identik dengan Books --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-2xl shadow-slate-200/50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="p-6 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] text-center w-24">Ikon</th>
                        <th class="p-6 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Nama Kategori</th>
                        <th class="p-6 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Volume Koleksi</th>
                        <th class="p-6 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Manajemen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($categories as $cat)
                    <tr class="hover:bg-rose-50/30 transition-all group">
                        <td class="p-6">
                            {{-- Placeholder Visual seperti Cover di Books --}}
                            <div class="w-14 h-14 mx-auto bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center font-black text-xl shadow-sm group-hover:scale-110 transition-transform duration-300 ring-4 ring-white">
                                {{ substr($cat->name, 0, 1) }}
                            </div>
                        </td>
                        <td class="p-6">
                            <div class="flex flex-col">
                                <span class="text-lg font-black text-slate-800 leading-none group-hover:text-rose-600 transition-colors">{{ $cat->name }}</span>
                                <code class="text-[10px] font-bold text-rose-400 mt-2 tracking-widest bg-rose-50 w-fit px-2 py-0.5 rounded uppercase">ID: #CAT-{{ str_pad($cat->id, 3, '0', STR_PAD_LEFT) }}</code>
                            </div>
                        </td>
                        <td class="p-6 text-center">
                            <div class="flex flex-col items-center">
                                <span class="text-2xl font-black text-slate-800">{{ $cat->books_count ?? 0 }}</span>
                                <span class="text-[9px] font-black uppercase tracking-widest text-rose-400">Judul Buku</span>
                            </div>
                        </td>
                        <td class="p-6 text-right">
                            <div class="flex justify-end items-center gap-2">
                                {{-- Tombol Edit - Sekarang Lebih Jelas --}}
                                <a href="{{ route('librarian.categories.edit', $cat->id) }}"
                                    class="w-10 h-10 flex items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all shadow-sm group/btn"
                                    title="Edit Kategori">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>

                                {{-- Tombol Hapus - Sekarang Lebih Jelas --}}
                                <button type="button"
                                    class="w-10 h-10 flex items-center justify-center rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all shadow-sm btn-delete-cat"
                                    data-id="{{ $cat->id }}"
                                    data-name="{{ $cat->name }}"
                                    title="Hapus Kategori">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>

                                <form id="delete-cat-form-{{ $cat->id }}" action="{{ route('librarian.categories.destroy', $cat->id) }}" method="POST" class="hidden">
                                    @csrf @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-slate-50 text-slate-300 rounded-[2rem] flex items-center justify-center mb-4">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-black text-slate-400">Belum ada kategori</h3>
                                <p class="text-slate-400 text-sm italic mt-1 font-medium">Klik tombol tambah kategori untuk memulai.</p>
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
    // Notifikasi Berhasil
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session("success") }}',
        showConfirmButton: false,
        timer: 2000,
        background: '#ffffff',
        iconColor: '#f43f5e',
        customClass: {
            title: 'font-black text-slate-800',
            popup: 'rounded-[2.5rem] border-none shadow-2xl'
        }
    });
    @endif

    // Konfirmasi Hapus
    document.querySelectorAll('.btn-delete-cat').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');

            Swal.fire({
                title: 'Hapus Kategori?',
                text: `Anda akan menghapus kategori "${name}". Data buku terkait mungkin terdampak!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f43f5e',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Hapus',
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
                    document.getElementById(`delete-cat-form-${id}`).submit();
                }
            });
        });
    });
</script>
@endsection