<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    use HasFactory;
    protected $table = 'sertifikats';
    protected $fillable = [
        'user_id',
        'no_sertifikat',
        'nama_pelatihan',
        'tanggal_berlaku',
        'tanggal_berakhir',
        'sertifikat_file',
        'role', // Add role to fillable
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
