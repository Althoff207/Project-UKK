<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Borrow extends Model
{
    use HasFactory;

    // Laravel otomatis mencari tabel 'borrows', jadi ini sudah aman
    protected $fillable = [
        'user_id', 
        'book_id', 
        'borrow_type', 
        'borrow_date', 
        'return_due_date', 
        'return_date', 
        'status'
    ];

    // Relasi agar kita bisa panggil $borrow->book->title
    public function book() {
        return $this->belongsTo(Book::class);
    }

    // Relasi agar kita bisa panggil $borrow->user->name
    public function user() {
        return $this->belongsTo(User::class);
    }
}