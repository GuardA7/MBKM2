<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelatihanUser extends Model
{
    use HasFactory;
    protected $table = 'pelatihan_user';
    // Define the fillable fields
    protected $fillable = [
        'user_id',
        'pelatihan_id',
        'bukti_pembayaran',
        'status_pendaftaran',
    ];

    // Define the relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship to the Pelatihan model
    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class);
    }
}
