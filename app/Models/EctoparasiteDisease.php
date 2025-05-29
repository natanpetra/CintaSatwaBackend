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
        'treatment',
        'image'
    ];
    
    protected $appends = ['image_url'];

    /** additional attribut, after make function, add to $appends variable */
    public function getImageUrlAttribute ()
    {
        $source = !empty($this->attributes['image']) ? "/storage/" . $this->attributes['image'] : "/img/no-image.png";
        return asset($source);
    }
}
