@extends('layouts.librarian')

@section('title', 'Proses Pengembalian')

@section('content')
<div class="mb-12">
    <div class="flex items-center gap-4 mb-3">
        <a href="{{ route('librarian.dashboard') }}" class="p-2 bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-indigo-600 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <span class="px-3 py-1 bg-rose-100 text-rose-600 text-[10px] font-black uppercase tracking-widest rounded-lg">Status: Borrowed</span>
    </div>
    <h1 class="text-4xl font-black text-slate-900 tracking-tight">Daftar Pengembalian</h1>
    <p class="text-slate-500 mt-2 font-medium italic text-sm">Monitor buku yang sedang dipinjam dan cek masa tenggat pengembalian.</p>
</div>

<div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
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
                    $dueDate = $borrowDate->copy()->addDays(7); // Asumsi durasi pinjam 7 hari
                    $isOverdue = \Carbon\Carbon::now()->gt($dueDate);
                @endphp
                <tr class="hover:bg-indigo-50/10 transition-all group">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 font-black text-xs group-hover:bg-indigo-600 group-hover:text-white transition-all shadow-inner">
                                {{ substr($b->user->name, 0, 1) }}
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
                            {{ $borrowDate->format('d M Y') }}
                        </span>
                    </td>
                    <td class="px-8 py-6 text-center">
                        <span class="text-[11px] font-black px-3 py-1.5 rounded-xl border {{ $isOverdue ? 'bg-rose-50 text-rose-600 border-rose-200 animate-pulse' : 'bg-amber-50 text-amber-600 border-amber-200' }}">
                            {{ $dueDate->format('d M Y') }}
                            @if($isOverdue)
                                <span class="block text-[8px] uppercase tracking-tighter">Terlambat!</span>
                            @endif
                        </span>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex justify-end">
                            <form action="{{ route('librarian.return.process', $b->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-indigo-700 hover:-translate-y-1 transition-all shadow-lg shadow-indigo-200 active:scale-95">
                                    Terima Buku
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-24 text-center text-slate-400 italic font-medium">Semua buku telah dikembalikan (Antrean kosong).</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection