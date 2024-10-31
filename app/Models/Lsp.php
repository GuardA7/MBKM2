<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lsp extends Model
{
    use HasFactory;

    protected $table = 'lsp';

    protected $fillable = ['nama'];

    public function pelatihan()
    {
        return $this->hasMany(Pelatihan::class);
    }
  
}
