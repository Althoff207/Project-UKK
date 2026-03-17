<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Pengguna - E-Lib Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-red-700 shadow-lg text-white mb-8">
        <div class="max-w-7xl mx-auto px-4 h-16 flex justify-between items-center">
            <div class="flex gap-6 items-center">
                <span class="font-bold text-xl tracking-wider">SUPERADMIN</span>
                <a href="{{ route('admin.dashboard') }}" class="text-sm opacity-80 hover:opacity-100">Dashboard</a>
                <a href="{{ route('admin.users.index') }}" class="text-sm font-bold border-b-2 border-white py-2">Kelola User</a>
            </div>
            <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="text-sm bg-red-800 px-4 py-2 rounded">Logout</button></form>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Pengguna</h1>
            
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari nama atau email..." 
                    class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 outline-none w-64 text-sm">
                <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-black">Cari</button>
                @if(request('search'))
                    <a href="{{ route('admin.users.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-bold hover:bg-gray-300">Reset</a>
                @endif
            </form>
        </div>

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-6 shadow">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded-xl shadow-sm overflow-hidden border">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase">Nama Pengguna</th>
                        <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase">Email</th>
                        <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase text-center">Role</th>
                        <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-gray-600 text-sm">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase
                                    {{ $user->role == 'admin' ? 'bg-red-100 text-red-700' : ($user->role == 'librarian' ? 'bg-indigo-100 text-indigo-700' : 'bg-green-100 text-green-700') }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right flex justify-end gap-3">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-blue-50 text-blue-600 px-3 py-1 rounded font-bold text-xs hover:bg-blue-600 hover:text-white transition">Edit</a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
                                    @csrf @method('DELETE')
                                    <button class="bg-red-50 text-red-600 px-3 py-1 rounded font-bold text-xs hover:bg-red-600 hover:text-white transition">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">Data user tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</body>
</html>