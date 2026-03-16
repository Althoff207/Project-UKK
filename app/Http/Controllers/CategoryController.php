<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('books')->latest()->get();
        return view('librarian.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('librarian.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name|max:255',
        ]);

        Category::create($request->all());

        return redirect()->route('librarian.categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(Category $category)
    {
        return view('librarian.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update($request->all());

        return redirect()->route('librarian.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Category $category)
    {
        // Cek jika kategori masih digunakan oleh buku
        if ($category->books()->count() > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki koleksi buku!');
        }

        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}
