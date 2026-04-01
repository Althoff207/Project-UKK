@extends('layouts.admin')

@section('title', 'Edit Akses')

@section('nav_icon_bg', 'bg-amber-500')
@section('nav_icon')
    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
@endsection

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white p-10 md:p-14 rounded-[3rem] shadow-2xl relative overflow-hidden border border-white">
        <div class="absolute top-0 left-0 w-full h-3 bg-gradient-to-r from-amber-500 to-rose-600"></div>

        <div class="mb-10 text-center">
            <h2 class="text-3xl font-black text-slate-900 uppercase tracking-tighter">Konfigurasi Akses</h2>
            <p class="text-slate-400 text-sm mt-2 font-medium">Mengelola kredensial: <span class="text-indigo-600 font-bold italic">{{ $user->email }}</span></p>
        </div>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Nama</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="w-full bg-slate-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-amber-500/10 focus:bg-white outline-none transition-all font-bold text-slate-800" required>
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Role</label>
                    <select name="role" class="w-full bg-slate-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-amber-500/10 focus:bg-white outline-none transition-all font-bold text-slate-800 appearance-none cursor-pointer">
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Siswa</option>
                        <option value="librarian" {{ $user->role == 'librarian' ? 'selected' : '' }}>Petugas</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="w-full bg-slate-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-amber-500/10 focus:bg-white outline-none transition-all font-bold text-slate-800" required>
            </div>

            <div class="bg-amber-50/50 p-6 rounded-[2rem] border border-amber-100/50 space-y-3">
                <label class="block text-[10px] font-black text-amber-700 uppercase tracking-widest">Ganti Password (Opsional)</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak berubah" class="w-full bg-white/60 border-none rounded-xl p-3 focus:ring-2 focus:ring-amber-500 outline-none transition text-sm text-slate-800 placeholder:text-amber-300 font-medium">
            </div>

            <div class="flex flex-col gap-3 pt-6">
                <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-[1.5rem] font-black text-sm uppercase tracking-widest shadow-xl hover:bg-amber-500 transition-all active:scale-95">Simpan Konfigurasi</button>
                <a href="{{ route('admin.users.index') }}" class="w-full text-center py-2 text-xs font-black text-slate-300 hover:text-rose-500 transition-colors uppercase tracking-widest">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection