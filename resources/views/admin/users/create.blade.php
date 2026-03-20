@extends('layouts.admin')

@section('title', 'Tambah Pengguna')

@section('nav_icon_bg', 'bg-emerald-500')
@section('nav_icon')
    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-center mb-10">
        <div class="bg-slate-200/50 p-1.5 rounded-[2rem] flex gap-1 shadow-inner border border-slate-100">
            <button type="button" onclick="switchTab('single')" id="btn-single" class="tab-btn px-8 py-3 rounded-[1.5rem] text-xs font-black uppercase tracking-widest transition-all bg-white text-emerald-600 shadow-sm border border-emerald-100">
                Satu Per Satu
            </button>
            <button type="button" onclick="switchTab('bulk')" id="btn-bulk" class="tab-btn px-8 py-3 rounded-[1.5rem] text-xs font-black uppercase tracking-widest transition-all text-slate-400 hover:text-indigo-500">
                Massal (Sekolah)
            </button>
        </div>
    </div>

    <div class="relative">
        
        <div id="form-single" class="transition-all duration-500">
            <div class="bg-white p-10 md:p-14 rounded-[3rem] shadow-2xl border border-white relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-3 bg-emerald-500"></div>
                
                <div class="text-center mb-10">
                    <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tighter">Registrasi Manual</h2>
                    <p class="text-slate-400 text-xs mt-2 font-medium italic">Tambahkan satu akun pengguna baru ke sistem.</p>
                </div>

                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Nama Lengkap</label>
                            <input type="text" name="name" class="w-full bg-slate-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-emerald-500/10 focus:bg-white outline-none transition-all font-bold text-slate-800" placeholder="Nama Siswa/Petugas" required>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Role Akses</label>
                            <select name="role" class="w-full bg-slate-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-emerald-500/10 focus:bg-white outline-none transition-all font-bold text-slate-800 cursor-pointer">
                                <option value="user">Siswa (User)</option>
                                <option value="librarian">Petugas (Librarian)</option>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Email Aktif</label>
                        <input type="email" name="email" class="w-full bg-slate-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-emerald-500/10 focus:bg-white outline-none transition-all font-bold text-slate-800" placeholder="email@sekolah.id" required>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Kata Sandi</label>
                        <input type="password" name="password" class="w-full bg-slate-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-emerald-500/10 focus:bg-white outline-none transition-all font-bold text-slate-800" placeholder="Minimal 8 Karakter" required>
                    </div>

                    <button type="submit" class="w-full bg-slate-900 text-white py-5 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] shadow-xl hover:bg-emerald-600 transition-all active:scale-95 mt-4">Simpan User Baru</button>
                </form>
            </div>
        </div>

        <div id="form-bulk" class="hidden transition-all duration-500">
            <div class="bg-white p-10 md:p-14 rounded-[3rem] shadow-2xl border border-white relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-3 bg-indigo-500"></div>

                <div class="text-center mb-10">
                    <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tighter">Impor Massal (CSV)</h2>
                    <p class="text-slate-400 text-xs mt-2 font-medium italic">Upload file data siswa satu angkatan sekaligus.</p>
                </div>

                <form action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    <div class="group relative w-full h-56 bg-slate-50 border-4 border-dashed border-slate-200 rounded-[3rem] flex flex-col items-center justify-center transition-all hover:border-indigo-400 hover:bg-indigo-50/30">
                        <input type="file" name="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" id="file-input" onchange="showFileName()">
                        <div class="text-center pointer-events-none p-6">
                            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            </div>
                            <p id="file-label" class="text-slate-500 font-bold text-sm">Pilih File CSV atau Excel</p>
                            <p class="text-slate-300 text-[10px] mt-1 font-medium italic uppercase tracking-widest">Maksimal 2MB</p>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white py-5 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] shadow-xl hover:bg-slate-900 transition-all active:scale-95">Mulai Impor Data</button>
                </form>
            </div>
        </div>

    </div>

    <div class="mt-12 text-center">
        <a href="{{ route('admin.users.index') }}" class="text-[10px] font-black text-slate-300 hover:text-rose-500 uppercase tracking-[0.3em] transition-colors italic">← Kembali ke Daftar Pengguna</a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function switchTab(type) {
        const formSingle = document.getElementById('form-single');
        const formBulk = document.getElementById('form-bulk');
        const btnSingle = document.getElementById('btn-single');
        const btnBulk = document.getElementById('btn-bulk');

        if (type === 'single') {
            formSingle.classList.remove('hidden');
            formBulk.classList.add('hidden');
            
            // UI Button Active
            btnSingle.className = "tab-btn px-8 py-3 rounded-[1.5rem] text-xs font-black uppercase tracking-widest transition-all bg-white text-emerald-600 shadow-sm border border-emerald-100";
            btnBulk.className = "tab-btn px-8 py-3 rounded-[1.5rem] text-xs font-black uppercase tracking-widest transition-all text-slate-400 hover:text-indigo-500";
        } else {
            formSingle.classList.add('hidden');
            formBulk.classList.remove('hidden');
            
            // UI Button Active
            btnBulk.className = "tab-btn px-8 py-3 rounded-[1.5rem] text-xs font-black uppercase tracking-widest transition-all bg-white text-indigo-600 shadow-sm border border-indigo-100";
            btnSingle.className = "tab-btn px-8 py-3 rounded-[1.5rem] text-xs font-black uppercase tracking-widest transition-all text-slate-400 hover:text-emerald-500";
        }
    }

    function showFileName() {
        const input = document.getElementById('file-input');
        const label = document.getElementById('file-label');
        if (input.files.length > 0) {
            label.innerText = "File Terpilih: " + input.files[0].name;
            label.classList.add('text-indigo-600');
        }
    }
</script>
@endsection