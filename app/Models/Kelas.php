<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'prodi_id'];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
