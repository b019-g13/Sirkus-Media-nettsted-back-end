<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use Traits\UsesUuid;

    //Kobling til pages
    public function page(){
        return $this->hasOne('App\Page');
    }

    // kobling til user
    public function user(){
       return $this->hasOne('App\User');
    }
    
    // Kobling til image_sizes
    public function image_size(){
        return $this->belongsTo('App\ImageSize', 'image_size_id');
    }

    // Kobling til component_field
    public function component_field(){
        return $this->hasOne('App\ComponentField');        
    }
}
