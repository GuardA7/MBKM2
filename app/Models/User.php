<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'nim',
        'nidn',
        'nik',
        'no_hp',
        'jenis_kelamin',
        'prodi_id',
        'kelas_id',
        'jurusan_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    // Method untuk mendapatkan role pengguna
    public function isMahasiswa()
    {
        return $this->role === 'mahasiswa';
    }

    public function isDosen()
    {
        return $this->role === 'dosen';
    }

    public function isMasyarakat()
    {
        return $this->role === 'masyarakat';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function pelatihan()
    {
        return $this->belongsToMany(Pelatihan::class)->withPivot('bukti_pembayaran', 'status_pendaftaran')->withTimestamps();
    }

public function sertifikats()
{
    return $this->hasMany(Sertifikat::class);
}

}
