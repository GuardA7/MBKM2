<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\KategoriPelatihan;

class Pelatihan extends Model
{
    use HasFactory;

    protected $table = 'pelatihan';

    // Menentukan atribut yang dapat diisi secara massal
    protected $fillable = [
        'nama',
        'jenis_pelatihan',
        'deskripsi',
        'tanggal_pendaftaran',
        'berakhir_pendaftaran',
        'harga',
        'kuota',
        'pembimbing',
        'lsp_id', // ID LSP
        'kategori_id', // ID Kategori
        'gambar',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriPelatihan::class);
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
