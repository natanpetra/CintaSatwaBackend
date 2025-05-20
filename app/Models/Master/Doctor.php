<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctors';
    protected $fillable = ['name', 'specialization', 'phone'];
}
