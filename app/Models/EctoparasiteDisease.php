<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EctoparasiteDisease extends Model
{
    use HasFactory;

    protected $table = 'ectoparasite_diseases';

    protected $fillable = [
        'name',
        'symptoms',
        'treatment'
    ];
}
