<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    // Jika nama tabel bukan plural dari model, bisa tentukan:
    protected $table = 'scan_result';

    // Kolom yang boleh diisi mass assignment
    protected $fillable = [
        'user_id',
        'photo',
    ];

    // Jika ingin otomatis cast created_at/updated_at ke Carbon instances
    public $timestamps = true;

    // (Opsional) Jika ingin mereturn URL lengkap:
    // public function getPhotoAttribute($value)
    // {
    //     return \Storage::url($value);
    // }
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
