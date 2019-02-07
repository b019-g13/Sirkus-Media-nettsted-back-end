<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComponentField extends Model
{   
    use Traits\UsesUuid;

    // tilkobling til ett image
    public function image(){
        // $this->hasOne('App\image', 'image_id');
    }

    // Kobling til en link
    public function link(){
        $this->hasOne('App\Link' , 'link_id');
    }
}
