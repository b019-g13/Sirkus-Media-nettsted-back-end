<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuLocation extends Model
{
    //
    public function menu(){
        $this->hasOne('App\Menu');
    }
}
