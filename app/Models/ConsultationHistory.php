<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationHistory extends Model
{
    use HasFactory;

    protected $table = 'consultation_history';

    protected $fillable = [
        'user_id',
        'doctor_id',
        'notes',
        'consultation_date'
    ];
}
