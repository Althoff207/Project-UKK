<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // PENTING

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new User([
            'name'     => $row['nama'],     // Harus sama dengan tulisan di kolom A1 Excel
            'email'    => $row['email'],    // Harus sama dengan tulisan di kolom B1 Excel
            'password' => Hash::make($row['password'] ?? 'siswa123'), // Default jika kosong
            'role'     => 'user',           // Otomatis jadi siswa
        ]);
    }
}