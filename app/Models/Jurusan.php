<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusans';

    protected $fillable = [
        'nama_jurusan',
    ];

    public function prodis()
    {
        return $this->hasMany(Prodi::class); // Pastikan model Prodi juga ada
    }

    public function dosens()
    {
        return $this->hasMany(User::class)->where('role', 'dosen'); // Hanya mengambil user dengan role 'dosen'
    }
}
