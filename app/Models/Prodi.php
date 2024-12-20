<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'prodis';
    protected $fillable = ['id','nama_prodi','jurusan_id','nama_jurusan'];

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id'); // Define the relationship to Jurusan
    }
}
