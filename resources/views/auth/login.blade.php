<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - ALPUS Althoff Perpustakaan</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at top left, #4f46e5 0%, #1e1b4b 100%);
            overflow: hidden; /* Mencegah scroll saat animasi */
            height: 100vh;
        }

        /* --- ANIMASI SYSTEM --- */
        @keyframes entrance {
            from { opacity: 0; transform: scale(0.95) translateY(20px); filter: blur(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); filter: blur(0); }
        }

        .animate-main {
            animation: entrance 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        }

        .exit-scale {
            opacity: 0 !important;
            transform: scale(1.05) !important;
            filter: blur(15px) !important;
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        /* --- GLASSMORPHISM --- */
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .input-focus {
            transition: all 0.3s ease;
        }
        .input-focus:focus {
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }
    </style>
</head>
<body class="flex items-center justify-center p-4">

    <div class="fixed top-[-10%] left-[-10%] w-[40%] h-[40%] bg-indigo-500 rounded-full mix-blend-screen filter blur-[120px] opacity-20 animate-pulse"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-purple-600 rounded-full mix-blend-screen filter blur-[120px] opacity-20 animate-pulse" style="animation-delay: 1s;"></div>

    <main class="w-full max-w-5xl flex flex-col md:flex-row gap-12 items-center animate-main">
        
        <div class="flex-1 text-white space-y-6 hidden md:block">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/20 text-[10px] font-bold tracking-[0.2em] uppercase">
                <span class="w-2 h-2 rounded-full bg-indigo-400 animate-ping"></span>
                Digital Library Ecosystem
            </div>
            <h1 class="text-6xl lg:text-8xl font-black tracking-tighter leading-none">
                ALPUS<br>
            </h1>
            <p class="text-lg text-indigo-100/70 max-w-md leading-relaxed font-medium">
                Selamat datang di pusat literasi digital. <br>Temukan ilmu, jelajahi dunia, dan kembangkan potensi diri bersama kami.
            </p>
            <div class="pt-6 flex items-center gap-4">
                <div class="h-[1px] w-12 bg-indigo-400"></div>
                <span class="text-sm font-bold tracking-widest uppercase opacity-50 italic">Read • Learn • Grow</span>
            </div>
        </div>

        <div class="w-full max-w-md glass-card rounded-[3rem] p-10 md:p-14 shadow-2xl relative">
            <div class="mb-10 text-center md:text-left">
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Login.</h2>
                <p class="text-slate-500 mt-2 font-medium">Akses akun perpustakaan Anda</p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-2xl mb-6 text-sm flex items-center gap-3 animate-bounce">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                    <span class="font-bold">{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" id="loginForm" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                        class="input-focus w-full px-6 py-4 bg-slate-100 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 focus:bg-white outline-none text-slate-800 font-medium" 
                        placeholder="name@email.com" required>
                </div>
                
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Secure Password</label>
                    <input type="password" name="password" 
                        class="input-focus w-full px-6 py-4 bg-slate-100 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 focus:bg-white outline-none text-slate-800 font-medium" 
                        placeholder="••••••••" required>
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-2xl transition-all shadow-xl shadow-indigo-200 active:scale-95 flex items-center justify-center gap-3 group">
                    Masuk Sekarang
                    <svg class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                </button>
            </form>

            <div class="mt-10 pt-8 border-t border-slate-100 text-center">
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em]">
                    &copy; {{ date('Y') }} ALPUS • Althoff Perpustakaan
                </p>
            </div>
        </div>
    </main>

    <script>
        // Transisi saat Submit Form
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            // Kita biarkan form submit secara natural, 
            // tapi kita beri efek "keluar" pada konten agar smooth ke dashboard
            document.querySelector('main').classList.add('exit-scale');
            document.body.style.transition = 'background 0.8s ease';
            document.body.style.background = '#1e1b4b'; // Menghitam perlahan
        });

        // Menangani jika user menekan tombol back
        window.addEventListener('pageshow', (event) => {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>
</body>
</html>