<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use Traits\UsesUuid;

    //Kobling til flere components
    public function components(){
       return $this->belongsToMany('App\Component', 'component_id');
    }
}
