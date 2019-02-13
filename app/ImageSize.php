<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageSize extends Model
{
    public $timestamps = false;

     //Har en image
    public function image()
    {
        return $this->hasOne('App\Image');
        
    }
}
