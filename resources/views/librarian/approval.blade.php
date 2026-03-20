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
    <p class="text-slate-500 mt-3 font-medium italic text-sm">Validasi pengajuan peminjaman untuk mengubah status menjadi <span class="text-indigo-600 font-bold not-italic">Borrowed</span>.</p>
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
                                {{ substr($req->user->name, 0, 1) }}
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
                            {{ \Carbon\Carbon::parse($req->created_at)->format('d M Y') }}
                        </span>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex justify-end gap-2">
                            <form action="{{ route('librarian.borrow.update', [$req->id, 'borrowed']) }}" method="POST" onsubmit="return confirm('Setujui peminjaman ini?')">
                                @csrf @method('PATCH')
                                <button type="submit" class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl hover:bg-emerald-600 hover:text-white transition-all shadow-sm border border-emerald-100 group/btn">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </button>
                            </form>

                            <form action="{{ route('librarian.borrow.update', [$req->id, 'rejected']) }}" method="POST" onsubmit="return confirm('Tolak permintaan ini?')">
                                @csrf @method('PATCH')
                                <button type="submit" class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition-all shadow-sm border border-rose-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-24 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-slate-50 text-slate-200 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-slate-400 italic font-bold tracking-tight">Antrean permintaan pinjam sudah bersih.</p>
                            <p class="text-slate-300 text-xs mt-1">Semua pengajuan telah diproses.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection