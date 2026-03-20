<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - ALPUS Admin</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; opacity: 0; transition: opacity 0.5s ease-in; }
        .glass-nav { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(15px); border-bottom: 1px solid rgba(226, 232, 240, 0.8); }
        
        /* Animasi Transisi Halaman */
        @keyframes slideInUp { from { opacity: 0; transform: translateY(20px); filter: blur(5px); } to { opacity: 1; transform: translateY(0); filter: blur(0); } }
        .animate-page { animation: slideInUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; }
        .exit-fade { opacity: 0 !important; transform: translateY(-20px) !important; filter: blur(10px); transition: all 0.4s ease-in-out !important; }

        /* Tirai Logout */
        #logout-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #1e1b4b; z-index: 9999; opacity: 0; pointer-events: none; transition: opacity 0.6s ease; display: flex; align-items: center; justify-content: center; }
        #logout-overlay.active { opacity: 1; pointer-events: auto; }

        .swal2-popup { border-radius: 2.5rem !important; padding: 2rem !important; }
    </style>
    @yield('styles')
</head>
<body class="min-h-screen pb-12">

    <div id="logout-overlay">
        <div class="text-center">
            <div class="w-12 h-12 border-4 border-indigo-400 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
            <p class="text-white text-[10px] font-black tracking-widest uppercase">Mengamankan Sesi...</p>
        </div>
    </div>

    <nav class="glass-nav sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 @yield('nav_icon_bg', 'bg-indigo-600') rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200">
                        @yield('nav_icon')
                    </div>
                    <span class="font-extrabold text-xl tracking-tighter text-slate-800 uppercase">ALPUS Admin</span>
                </div>
                <div class="hidden md:flex items-center gap-1 bg-slate-100 p-1 rounded-2xl">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link px-6 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('admin.dashboard') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-indigo-600' }} transition-all">Dashboard</a>
                    <a href="{{ route('admin.users.index') }}" class="nav-link px-6 py-2.5 rounded-xl text-sm font-bold {{ request()->routeIs('admin.users.*') ? 'bg-white text-rose-600 shadow-sm' : 'text-slate-500 hover:text-rose-600' }} transition-all">Kelola User</a>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST" id="formLogout">
                @csrf
                <button type="button" onclick="confirmLogout()" class="bg-slate-900 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-rose-600 transition-all active:scale-95 shadow-lg shadow-slate-200">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-12 animate-page">
        @yield('content')
    </main>

    <script>
        window.addEventListener('DOMContentLoaded', () => { document.body.style.opacity = "1"; });

        function confirmLogout() {
            Swal.fire({
                title: 'Selesai Bertugas?',
                text: "Pastikan semua pekerjaan Anda telah tersimpan.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1e1b4b',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-overlay').classList.add('active');
                    setTimeout(() => { document.getElementById('formLogout').submit(); }, 800);
                }
            })
        }

        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                if (this.hostname === window.location.hostname) {
                    e.preventDefault();
                    const url = this.href;
                    document.querySelector('main').classList.add('exit-fade');
                    setTimeout(() => { window.location.href = url; }, 400);
                }
            });
        });

        const successMsg = "{{ session('success') }}";
        if (successMsg) {
            Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true }).fire({ icon: 'success', title: successMsg });
        }
    </script>
    @yield('scripts')
</body>
</html>