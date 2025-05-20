<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    protected $table = 'clinics';
    protected $fillable = ['name', 'address', 'phone', 'schedule'];
}
