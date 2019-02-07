<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageSize extends Model
{
    use Traits\UsesUuid;
    public $timestamps = false;

     //Har en image
    public function image(){
        $this->hasOne('App\Image');
    }
}
