<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use Traits\UsesUuid;

    //Kobling til pages
    public function page(){
        $this->belongsTo('App\Page');
    }

    // kobling til user
    public function user(){
        $this->hasOne('App\User');
    }
    
    // Kobling til image_sizes
    public function image_size(){
        $this->hasOne('App\ImageSize', 'image_size_id');
    }

    // Kobling til component_field
    public function component_field(){
        $this->hasOne('App\ComponentField');        
    }
}
