<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['name', 'description', 'image', 'price', 'stock', 'category'];
    protected $appends = ['image_url'];

    /** additional attribut, after make function, add to $appends variable */
    public function getImageUrlAttribute ()
    {
        $source = !empty($this->attributes['image']) ? "/storage/" . $this->attributes['image'] : "/img/no-image.png";
        return asset($source);
    }
}
