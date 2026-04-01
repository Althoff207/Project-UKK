<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    protected $table = 'books';

    protected $fillable = [
        'title', 
        'author', 
        'publisher', 
        'year', 
        'stock', 
        'category_id', 
        'book_cover',
        'synopsis'
    ];

    /**
     * Relasi ke model Category
     * Satu buku memiliki satu kategori (BelongsTo)
     */
    public function category(): BelongsTo
    {
        // Parameter kedua adalah foreign key di tabel books
        return $this->belongsTo(Category::class, 'category_id');
    }
}
