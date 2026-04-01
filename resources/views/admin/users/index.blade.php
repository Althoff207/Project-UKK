@extends('layouts.admin')

@section('title', 'Kelola User')

@section('nav_icon_bg', 'bg-rose-600')
@section('nav_icon')
<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
</svg>
@endsection

@section('content')
<div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
    <div>
        <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-none">Manajemen Pengguna</h1>
        <p class="text-slate-500 mt-3 font-medium">Total <span class="text-rose-600 font-bold tracking-widest uppercase text-xs mx-1">{{ $users->total() }}</span> Akun Terdaftar</p>
    </div>

    <div class="flex flex-col sm:flex-row items-center gap-4">
        <a href="{{ route('admin.users.create') }}" class="group flex items-center gap-3 bg-slate-900 text-white px-6 py-4 rounded-[1.5rem] font-black text-xs uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-xl shadow-slate-200 active:scale-95">
            <svg class="w-5 h-5 text-emerald-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah User
        </a>

        <form action="{{ route('admin.users.index') }}" method="GET" class="relative group">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari user..." class="pl-12 pr-4 py-4 bg-white border-none rounded-[1.5rem] focus:ring-4 focus:ring-rose-500/10 outline-none w-full md:w-64 text-sm transition-all shadow-xl shadow-slate-200/50 font-bold">
            <div class="absolute left-4 top-4 text-slate-300 group-focus-within:text-rose-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </form>
    </div>
</div>

<div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 border border-white overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                    <th class="px-8 py-6">Profil Pengguna</th>
                    <th class="px-8 py-6 text-center">Role</th>
                    <th class="px-8 py-6 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($users as $user)
                <tr class="hover:bg-slate-50/80 transition-all group">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-sm uppercase group-hover:bg-rose-600 group-hover:text-white transition-all shadow-inner">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 text-base leading-none">{{ $user->name }}</p>
                                <p class="text-slate-400 text-xs mt-1 italic font-medium">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6 text-center">
                        <span class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $user->role == 'admin' ? 'bg-rose-50 text-rose-600' : ($user->role == 'librarian' ? 'bg-indigo-50 text-indigo-600' : 'bg-emerald-50 text-emerald-600') }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-4 group-hover:translate-x-0">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="p-3 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </a>
                            
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="form-delete inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn-delete p-3 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-10 text-slate-400 italic">Data tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $users->links() }}
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.form-delete');
            Swal.fire({
                title: 'Hapus User?',
                text: "Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        });
    });
</script>
@endsection 