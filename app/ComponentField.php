<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComponentField extends Model
{   
    use Traits\UsesUuid;

    // tilkobling til ett image
    public function image(){
       return  $this->hasOne('App\image', 'image_id');
    }

    // Kobling til en link
    public function link(){
       return $this->hasOne('App\Link' , 'link_id');
    }
}
