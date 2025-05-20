<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products'; // Sesuaikan dengan nama tabel di database

    protected $fillable = [
        'name', // Sesuaikan dengan kolom yang ada di database
        'price',
        'stock',
        'category',
        'image',
        'description',
    ];
    
    protected $appends = ['image_url'];

    /** additional attribut, after make function, add to $appends variable */
    public function getImageUrlAttribute ()
    {
        $source = !empty($this->attributes['image']) ? "/storage/" . $this->attributes['image'] : "/img/no-image.png";
        return asset($source);
    }
}
