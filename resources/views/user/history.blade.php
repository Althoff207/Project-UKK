@extends('layouts.user')

@section('title', 'Riwayat Pinjam')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Riwayat Peminjaman</h1>
        <p class="text-slate-500 mt-1 font-medium">Pantau status buku yang Anda pinjam di sini secara real-time.</p>
    </div>

    <div class="bg-white shadow-xl shadow-slate-200/50 border border-slate-100 rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Buku</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Tanggal Pinjam</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Batas Kembali</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($histories as $history)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="h-14 w-10 bg-slate-100 rounded-lg flex-shrink-0 overflow-hidden shadow-sm group-hover:shadow-md transition-all border border-slate-200">
                                        @if($history->book->book_cover)
                                            <img src="{{ asset('storage/' . $history->book->book_cover) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-indigo-50 text-indigo-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-800 text-base leading-tight">{{ $history->book->title }}</span>
                                        <span class="text-xs text-slate-400 font-medium">ISBN: {{ $history->book->isbn ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-slate-600 font-semibold">
                                {{ \Carbon\Carbon::parse($history->borrow_date)->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-8 py-6 text-slate-600 font-semibold">
                                {{ \Carbon\Carbon::parse($history->return_due_date)->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-8 py-6 text-center">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'approved' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'rejected' => 'bg-rose-50 text-rose-600 border-rose-100',
                                        'returned' => 'bg-slate-100 text-slate-500 border-slate-200'
                                    ];
                                    $statusLabels = [
                                        'pending' => 'Menunggu',
                                        'approved' => 'Dipinjam',
                                        'rejected' => 'Ditolak',
                                        'returned' => 'Selesai'
                                    ];
                                @endphp
                                <span class="px-4 py-1.5 border {{ $statusClasses[$history->status] ?? $statusClasses['returned'] }} rounded-full text-[10px] font-black uppercase tracking-widest shadow-sm">
                                    {{ $statusLabels[$history->status] ?? 'Kembali' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center justify-center opacity-40">
                                    <svg class="w-16 h-16 mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <p class="text-slate-500 italic font-medium">Belum ada riwayat aktivitas peminjaman.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection 