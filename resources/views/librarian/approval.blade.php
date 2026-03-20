@extends('layouts.librarian')

@section('title', 'Antrean Persetujuan')

@section('content')
<div class="mb-12">
    <div class="flex items-center gap-4 mb-3">
        <a href="{{ route('librarian.dashboard') }}" class="p-2 bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-indigo-600 transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <span class="px-3 py-1 bg-amber-100 text-amber-600 text-[10px] font-black uppercase tracking-widest rounded-lg border border-amber-200/50">
            {{ $requests->count() }} Permintaan Menunggu
        </span>
    </div>
    <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-none">Antrean Persetujuan</h1>
    <p class="text-slate-500 mt-3 font-medium italic text-sm">Validasi pengajuan peminjaman untuk mengubah status menjadi <span class="text-indigo-600 font-bold not-italic">Dipinjam</span>.</p>
</div>

<div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">
                    <th class="px-8 py-6">Data Siswa</th>
                    <th class="px-8 py-6">Informasi Buku</th>
                    <th class="px-8 py-6 text-center">Tgl Request</th>
                    <th class="px-8 py-6 text-right">Aksi Keputusan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($requests as $req)
                <tr class="hover:bg-slate-50/50 transition-all group">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 font-black text-xs group-hover:bg-indigo-600 group-hover:text-white transition-all shadow-inner border border-slate-200/50">
                                {{ strtoupper(substr($req->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 text-sm leading-none">{{ $req->user->name }}</p>
                                <p class="text-slate-400 text-[9px] mt-1 italic tracking-tight uppercase">{{ $req->user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex flex-col">
                            <span class="font-bold text-slate-700 text-sm italic leading-tight">"{{ $req->book->title }}"</span>
                            <span class="text-[10px] text-slate-400 mt-1 font-medium">Stok saat ini: {{ $req->book->stock }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-6 text-center">
                        <span class="text-[11px] font-black text-slate-500 bg-slate-100 px-3 py-1.5 rounded-xl border border-slate-200/50 italic">
                            {{ \Carbon\Carbon::parse($req->created_at)->translatedFormat('d M Y') }}
                        </span>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex justify-end gap-2">
                            {{-- Tombol Setujui --}}
                            <button type="button" 
                                class="btn-approve p-2.5 bg-emerald-50 text-emerald-600 rounded-xl hover:bg-emerald-600 hover:text-white transition-all shadow-sm border border-emerald-100"
                                data-id="{{ $req->id }}" 
                                data-name="{{ $req->user->name }}" 
                                data-book="{{ $req->book->title }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </button>
                            <form id="approve-form-{{ $req->id }}" action="{{ route('librarian.borrow.update', ['id' => $req->id, 'status' => 'approved']) }}" method="POST" class="hidden">
                                @csrf @method('PATCH')
                            </form>

                            {{-- Tombol Tolak --}}
                            <button type="button" 
                                class="btn-reject p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition-all shadow-sm border border-rose-100"
                                data-id="{{ $req->id }}" 
                                data-name="{{ $req->user->name }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                            <form id="reject-form-{{ $req->id }}" action="{{ route('librarian.borrow.update', ['id' => $req->id, 'status' => 'rejected']) }}" method="POST" class="hidden">
                                @csrf @method('PATCH')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-24 text-center">
                        <p class="text-slate-400 italic font-bold">Antrean permintaan pinjam sudah bersih.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- SCRIPT SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // 1. Notifikasi Berhasil (Sukses Update)
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session("success") }}',
        showConfirmButton: false,
        timer: 2000,
        background: '#ffffff',
        iconColor: '#10b981', {{-- Warna emerald --}}
        customClass: {
            title: 'font-black text-slate-800',
            popup: 'rounded-[2.5rem] border-none shadow-2xl'
        }
    });
    @endif

    // 2. Konfirmasi Setuju (Approve)
    document.querySelectorAll('.btn-approve').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const book = this.getAttribute('data-book');

            Swal.fire({
                title: 'Setujui Pinjaman?',
                text: `Siswa "${name}" akan meminjam buku "${book}". Pastikan fisik buku sudah diserahkan!`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5', {{-- Indigo --}}
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Setujui',
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
                    document.getElementById(`approve-form-${id}`).submit();
                }
            });
        });
    });

    // 3. Konfirmasi Tolak (Reject)
    document.querySelectorAll('.btn-reject').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');

            Swal.fire({
                title: 'Tolak Permintaan?',
                text: `Permintaan pinjam atas nama "${name}" akan dibatalkan dan stok buku dikembalikan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f43f5e', {{-- Rose/Red --}}
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Tolak',
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
                    document.getElementById(`reject-form-${id}`).submit();
                }
            });
        });
    });
</script>
@endsection