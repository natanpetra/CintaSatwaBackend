<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    // Jika nama tabel bukan plural dari model, bisa tentukan:
    protected $table = 'reservations';

    protected $fillable = [
        'user_id',
        'pet_name',
        'pet_type',
        'reservation_date',
        'reservation_time',
        'symptoms',
        'doctor_notes'
    ];

    public $timestamps = true;

    // (Opsional) Cast kolom–kolom date/time ke Carbon
    protected $casts = [
        'reservation_date' => 'date',
        'reservation_time' => 'datetime:H:i',
    ];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
