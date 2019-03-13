<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use Traits\UsesUuid;

    // kobling til user
    public function user(){
       return $this->hasOne('App\User');
    }
    
    // Kobling til image_sizes
    public function image_size(){
        return $this->hasOne('App\ImageSize');
    }

}
