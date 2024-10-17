<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    use HasFactory;

    protected $fillable = [
       'user_id',
        'nama_pelatihan',
        'tanggal_berlaku',
        'tanggal_berakhir',
        'sertifikat_file',
    ];


    // Sertifikat.php
public function user()
{
    return $this->belongsTo(User::class);
}

}
