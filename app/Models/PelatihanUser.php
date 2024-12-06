<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelatihanUser extends Model
{
    use HasFactory;

    protected $table = 'pelatihan_user';

    protected $fillable = [
        'user_id',
        'pelatihan_id',
        'bukti_pembayaran',
        'status_pendaftaran',
        'status_kelulusan,'
    ];

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Pelatihan
     */
    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class);
    }
}
