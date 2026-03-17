<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Pengguna - Superadmin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white p-8 rounded-2xl shadow-xl border relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-red-600"></div>

            <h2 class="text-2xl font-black mb-1 text-gray-800 uppercase tracking-tight">Edit Akses</h2>
            <p class="text-gray-500 text-xs mb-8">Memperbarui hak akses untuk: <span class="font-bold text-red-600">{{ $user->email }}</span></p>

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Input Nama --}}
                <div>
                    <label class="block text-xs font-black text-gray-500 uppercase mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ $user->name }}"
                        class="w-full border-2 rounded-xl p-3 focus:border-red-500 outline-none transition font-medium" required>
                </div>

                {{-- Input Email --}}
                <div>
                    <label class="block text-xs font-black text-gray-500 uppercase mb-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ $user->email }}"
                        class="w-full border-2 rounded-xl p-3 focus:border-red-500 outline-none transition font-medium" required>
                </div>

                {{-- Input Role --}}
                <div>
                    <label class="block text-xs font-black text-gray-500 uppercase mb-1">Level Pengguna (Role)</label>
                    <select name="role" class="w-full border-2 rounded-xl p-3 focus:border-red-500 outline-none transition font-medium bg-gray-50">
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Siswa (User)</option>
                        <option value="librarian" {{ $user->role == 'librarian' ? 'selected' : '' }}>Petugas (Librarian)</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrator (Admin)</option>
                    </select>
                </div>

                {{-- Input Password Baru --}}
                <div class="bg-yellow-50 p-4 rounded-xl border border-yellow-100">
                    <label class="block text-xs font-black text-yellow-700 uppercase mb-1">Ganti Password (Opsional)</label>
                    <input type="password" name="password" placeholder="Isi hanya jika ingin ganti password"
                        class="w-full border-2 border-yellow-200 rounded-lg p-3 focus:border-yellow-500 outline-none transition text-sm">
                    <p class="text-[10px] text-yellow-600 mt-2">*Kosongkan jika tidak ingin mengubah password user.</p>
                </div>

                <div class="flex flex-col gap-2 pt-4">
                    <button type="submit" class="w-full bg-red-600 text-white py-3 rounded-xl font-bold shadow-lg hover:bg-red-700 transition transform active:scale-95">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="w-full text-center py-3 text-sm font-bold text-gray-400 hover:text-gray-600 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>