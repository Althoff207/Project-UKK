<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - ALPUS Digital Library</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; opacity: 0; transition: opacity 0.5s ease-in; }
        .glass-nav { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(15px); border-bottom: 1px solid rgba(226, 232, 240, 0.8); }
        
        /* Animasi Transisi Halaman */
        @keyframes slideInUp { from { opacity: 0; transform: translateY(20px); filter: blur(5px); } to { opacity: 1; transform: translateY(0); filter: blur(0); } }
        .animate-page { animation: slideInUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; }
        .exit-fade { opacity: 0 !important; transform: translateY(-20px) !important; filter: blur(10px); transition: all 0.4s ease-in-out !important; }

        /* Tirai Logout */
        #logout-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #1e1b4b; z-index: 9999; opacity: 0; pointer-events: none; transition: opacity 0.6s ease; display: flex; align-items: center; justify-content: center; }
        #logout-overlay.active { opacity: 1; pointer-events: auto; }

        .swal2-popup { border-radius: 2.5rem !important; padding: 2rem !important; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
    @yield('styles')
</head>
<body class="min-h-screen pb-12">

    <div id="logout-overlay">
        <div class="text-center">
            <div class="w-12 h-12 border-4 border-indigo-400 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
            <p class="text-white text-[10px] font-black tracking-widest uppercase">Mengamankan Sesi Anda...</p>
        </div>
    </div>

    <nav class="glass-nav sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200 group">
                        <svg class="w-6 h-6 text-white group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <span class="font-extrabold text-xl tracking-tighter text-slate-800 uppercase leading-none">ALPUS</span>
                </div>

                <div class="hidden md:flex items-center gap-1 bg-slate-100 p-1 rounded-2xl border border-slate-200">
                    <a href="{{ route('user.dashboard') }}" 
                       class="nav-transition px-6 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('user.dashboard') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-indigo-600' }}">
                        Katalog
                    </a>
                    <a href="{{ route('user.history') }}" 
                       class="nav-transition px-6 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('user.history') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-indigo-600' }}">
                        Riwayat
                    </a>
                </div>
            </div>

            <div class="flex items-center gap-6">
                {{-- TOMBOL KHUSUS ADMIN (DIADAPTASI DARI LAYOUT STAFF) --}}
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="hidden lg:block bg-rose-600 hover:bg-slate-900 text-white text-[10px] px-5 py-2.5 rounded-xl font-black uppercase tracking-widest transition-all shadow-lg active:scale-95">
                        Admin Panel
                    </a>
                @endif

                <div class="hidden sm:flex flex-col text-right pr-6 border-r border-slate-200">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 leading-none mb-1.5">Personal Portal</p>
                    <p class="text-sm font-bold text-slate-800 leading-none tracking-tight">{{ auth()->user()->name }}</p>
                </div>

                <form action="{{ route('logout') }}" method="POST" id="formLogout">
                    @csrf
                    <button type="button" onclick="confirmLogout()" class="bg-slate-900 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-rose-600 transition-all active:scale-95 shadow-lg shadow-slate-200">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-12 animate-page">
        @yield('content')
    </main>

    <script>
        // Smooth Page Entry
        window.addEventListener('DOMContentLoaded', () => { document.body.style.opacity = "1"; });

        // Identical Logout Confirmation
        function confirmLogout() {
            Swal.fire({
                title: 'Selesai Membaca?',
                text: "Sesi Anda akan diakhiri demi keamanan akun.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1e1b4b',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Keluar',
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
                    document.getElementById('logout-overlay').classList.add('active');
                    setTimeout(() => { document.getElementById('formLogout').submit(); }, 800);
                }
            })
        }

        // Identical Page Exit Animation
        document.querySelectorAll('.nav-transition').forEach(link => {
            link.addEventListener('click', function(e) {
                if (this.hostname === window.location.hostname) {
                    e.preventDefault();
                    const url = this.href;
                    document.querySelector('main').classList.add('exit-fade');
                    setTimeout(() => { window.location.href = url; }, 400);
                }
            });
        });

        // Identical Global Success Toast
        const successMsg = "{{ session('success') }}";
        if (successMsg) {
            Swal.mixin({ 
                toast: true, 
                position: 'top-end', 
                showConfirmButton: false, 
                timer: 3000, 
                timerProgressBar: true 
            }).fire({ 
                icon: 'success', 
                title: successMsg 
            });
        }
    </script>
    @yield('scripts')
</body>
</html>