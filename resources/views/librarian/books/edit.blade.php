<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Buku - E-Lib</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-indigo-700 shadow-lg mb-8 text-white">
    <div class="max-w-7xl mx-auto px-4 h-16 flex justify-between items-center">
        <div class="flex gap-6 items-center">
            <span class="font-bold text-xl tracking-wider mr-4">ALPUS LIBRARIAN</span>
            <a href="{{ route('librarian.dashboard') }}" class="text-sm opacity-80 hover:opacity-100 py-2">Persetujuan</a>
            <a href="{{ route('librarian.returns') }}" class="text-sm opacity-80 hover:opacity-100 py-2">Pengembalian</a>
            <a href="{{ route('librarian.books.index') }}" class="text-sm font-bold border-b-2 border-white py-2">Kelola Buku</a>
            <a href="{{ route('librarian.categories.index') }}" class="text-sm opacity-80 hover:opacity-100 py-2">Kategori</a>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="text-sm bg-indigo-800 px-4 py-2 rounded">Logout</button>
        </form>
    </div>
</nav>
    <div class="max-w-3xl mx-auto py-12 px-4">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-blue-600 p-6 text-white">
                <h2 class="text-xl font-bold">Edit Data Buku</h2>
            </div>
            
            <form action="{{ route('librarian.books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Judul Buku</label>
                        <input type="text" name="title" value="{{ $book->title }}" class="w-full border rounded-lg p-2.5" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Penulis</label>
                        <input type="text" name="author" value="{{ $book->author }}" class="w-full border rounded-lg p-2.5" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                        <select name="category_id" class="w-full border rounded-lg p-2.5" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $book->category_id == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Stok</label>
                        <input type="number" name="stock" value="{{ $book->stock }}" class="w-full border rounded-lg p-2.5" required>
                    </div>

                    <div class="col-span-2 flex gap-4 items-center bg-gray-50 p-4 rounded-lg">
                        <div class="w-20 h-28 bg-gray-200 rounded overflow-hidden flex-shrink-0">
                            @if($book->book_cover)
                                <img src="{{ asset('storage/'.$book->book_cover) }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Ganti Cover (Kosongkan jika tidak diubah)</label>
                            <input type="file" name="book_cover" class="text-sm text-gray-500">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4 mt-8 pt-6 border-t">
                    <a href="{{ route('librarian.books.index') }}" class="text-sm font-bold text-gray-500">Batal</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg transition shadow-md">
                        Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>