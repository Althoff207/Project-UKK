<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
   use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];
    
    // Matikan timestamps jika di tabel lama kamu tidak ada created_at/updated_at
    public $timestamps = true;
}
