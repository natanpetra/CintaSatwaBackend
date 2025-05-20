<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    protected $table = 'dog_care_guides';
    protected $fillable = ['title', 'content', 'image'];

    protected $appends = ['image_url'];

    /** additional attribut, after make function, add to $appends variable */
    public function getImageUrlAttribute ()
    {
        $source = !empty($this->attributes['image']) ? "/storage/" . $this->attributes['image'] : "/img/no-image.png";
        return asset($source);
    }
}
