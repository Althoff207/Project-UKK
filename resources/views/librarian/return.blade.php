@extends('layouts.librarian')

@section('title', 'Proses Pengembalian')

@section('content')
<div class="mb-12">
    <div class="flex items-center gap-4 mb-3">
        <a href="{{ route('librarian.dashboard') }}" class="p-2 bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-indigo-600 transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <span class="px-3 py-1 bg-rose-100 text-rose-600 text-[10px] font-black uppercase tracking-widest rounded-lg border border-rose-200/50">
            Status: Sedang Dipinjam
        </span>
    </div>
    <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-none">Daftar Pengembalian</h1>
    <p class="text-slate-500 mt-3 font-medium italic text-sm">Monitor buku yang sedang dipinjam dan cek masa tenggat pengembalian.</p>
</div>

<div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">
                    <th class="px-8 py-6">Peminjam</th>
                    <th class="px-8 py-6">Informasi Buku</th>
                    <th class="px-8 py-6 text-center">Tgl Pinjam</th>
                    <th class="px-8 py-6 text-center">Tenggat Waktu</th>
                    <th class="px-8 py-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($borrows as $b)
                @php
                    $borrowDate = \Carbon\Carbon::parse($b->borrow_date);
                    $dueDate = $borrowDate->copy()->addDays(7); // Durasi pinjam 7 hari
                    $isOverdue = \Carbon\Carbon::now()->gt($dueDate);
                @endphp
                <tr class="hover:bg-indigo-50/10 transition-all group">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 font-black text-xs group-hover:bg-indigo-600 group-hover:text-white transition-all shadow-inner border border-slate-200/50">
                                {{ strtoupper(substr($b->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 text-sm leading-none">{{ $b->user->name }}</p>
                                <p class="text-slate-400 text-[9px] mt-1 font-medium tracking-tight italic">{{ $b->user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-bold text-slate-700 text-sm italic leading-tight">"{{ $b->book->title }}"</p>
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-1 italic">Status: Borrowed</p>
                    </td>
                    <td class="px-8 py-6 text-center">
                        <span class="text-[11px] font-bold text-slate-500 italic">
                            {{ $borrowDate->translatedFormat('d M Y') }}
                        </span>
                    </td>
                    <td class="px-8 py-6 text-center">
                        <span class="text-[11px] font-black px-3 py-1.5 rounded-xl border {{ $isOverdue ? 'bg-rose-50 text-rose-600 border-rose-200 animate-pulse' : 'bg-amber-50 text-amber-600 border-amber-200' }}">
                            {{ $dueDate->translatedFormat('d M Y') }}
                            @if($isOverdue)
                                <span class="block text-[8px] uppercase tracking-tighter">Terlambat!</span>
                            @endif
                        </span>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex justify-end">
                            {{-- Tombol Pemicu Swal --}}
                            <button type="button" 
                                class="btn-return px-6 py-2.5 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-slate-900 hover:-translate-y-1 transition-all shadow-xl shadow-indigo-100 active:scale-95"
                                data-id="{{ $b->id }}"
                                data-name="{{ $b->user->name }}"
                                data-book="{{ $b->book->title }}">
                                Terima Buku
                            </button>

                            {{-- Form Hidden --}}
                            <form id="return-form-{{ $b->id }}" action="{{ route('librarian.return.process', $b->id) }}" method="POST" class="hidden">
                                @csrf @method('PATCH')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-32 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-slate-50 text-slate-200 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <p class="text-slate-400 italic font-bold tracking-tight">Semua buku telah dikembalikan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Script SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // 1. Notifikasi Sukses
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session("success") }}',
        showConfirmButton: false,
        timer: 2000,
        background: '#ffffff',
        iconColor: '#4f46e5',
        customClass: {
            title: 'font-black text-slate-800',
            popup: 'rounded-[2.5rem] border-none shadow-2xl'
        }
    });
    @endif

    // 2. Konfirmasi Terima Buku
    document.querySelectorAll('.btn-return').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const book = this.getAttribute('data-book');

            Swal.fire({
                title: 'Terima Pengembalian?',
                text: `Konfirmasi bahwa buku "${book}" telah dikembalikan oleh ${name} dalam kondisi baik.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Terima Buku',
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
                    document.getElementById(`return-form-${id}`).submit();
                }
            });
        });
    });
</script>
@endsection