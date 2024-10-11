<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    use HasFactory;

    protected $table = 'pelatihan';

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function lsp()
    {
        return $this->belongsTo(Lsp::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('bukti_pembayaran', 'status_pendaftaran')->withTimestamps();
    }
}
