<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('category')->latest()->get();
        return view('librarian.books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('librarian.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'category_id' => 'required',
            'stock' => 'required|numeric',
            'book_cover' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('book_cover')) {
            $data['book_cover'] = $request->file('book_cover')->store('covers', 'public');
        }

        Book::create($data);
        return redirect()->route('librarian.books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('librarian.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required',
            'stock' => 'required|numeric',
        ]);

        $data = $request->all();

        if ($request->hasFile('book_cover')) {
            if ($book->book_cover) Storage::disk('public')->delete($book->book_cover);
            $data['book_cover'] = $request->file('book_cover')->store('covers', 'public');
        }

        $book->update($data);
        return redirect()->route('librarian.books.index')->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy(Book $book)
    {
        if ($book->book_cover) Storage::disk('public')->delete($book->book_cover);
        $book->delete();
        return back()->with('success', 'Buku berhasil dihapus!');
    }
}
