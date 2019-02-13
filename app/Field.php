<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use Traits\UsesUuid;

    //Kobling til component_field
    public function component_fields()
    {
       return $this->hasMany('App\ComponentField');
    }
}
