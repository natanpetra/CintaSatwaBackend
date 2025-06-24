<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Scan extends Model
{
    protected $table = 'scan_result';
    
    protected $fillable = [
        'user_id',
        'photo',
        'reservation_date',
        'reservation_time'
    ];

    // Accessor untuk format tanggal yang lebih sederhana
    public function getFormattedDateAttribute()
    {
        return $this->reservation_date ? 
            Carbon::parse($this->reservation_date)->format('d/m/Y') : '-';
    }

    public function getFormattedTimeAttribute()
    {
        return $this->reservation_time ? 
            Carbon::parse($this->reservation_time)->format('H:i') : '-';
    }
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}