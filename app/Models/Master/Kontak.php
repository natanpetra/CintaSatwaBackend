<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    protected $table = 'kontak';
    protected $fillable = ['nama', 'email', 'pesan', 'tanggal', 'status'];
  
}
