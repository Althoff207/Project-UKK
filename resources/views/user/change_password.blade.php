@extends('layouts.user') @section('title', 'Amankan Akun Anda')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-slate-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-[3rem] shadow-2xl border border-slate-100 relative overflow-hidden">
        
        <div class="absolute top-0 left-0 w-full h-3 bg-emerald-500"></div>

        <div class="text-center">
            <h2 class="text-3xl font-black text-slate-900 uppercase tracking-tighter">Ganti Password</h2>
            <p class="mt-2 text-sm text-slate-500 font-medium">Halo <span class="font-bold text-emerald-600">{{ auth()->user()->name }}</span>, ini adalah login pertamamu. Silakan buat password baru demi keamanan akun.</p>
        </div>

        <form class="mt-8 space-y-6" action="{{ route('user.password.update-first') }}" method="POST">
            @csrf
            
            <div class="space-y-4">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Password Baru</label>
                    <input type="password" name="password" required class="w-full bg-slate-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-emerald-500/10 outline-none transition-all font-bold text-slate-800" placeholder="Minimal 8 karakter">
                    @error('password')
                        <p class="text-rose-500 text-xs mt-1 ml-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Ulangi Password Baru</label>
                    <input type="password" name="password_confirmation" required class="w-full bg-slate-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-emerald-500/10 outline-none transition-all font-bold text-slate-800" placeholder="Ketik ulang password">
                </div>
            </div>

            <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] shadow-xl hover:bg-emerald-600 transition-all active:scale-95">
                Simpan & Lanjutkan
            </button>
        </form>
    </div>
</div>
@endsection