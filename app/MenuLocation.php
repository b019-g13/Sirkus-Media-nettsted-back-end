<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuLocation extends Model
{
    public $timestamps = false;
    use Traits\UsesUuid;
    
    // Har bare en menu
    public function menu(){
        $this->hasOne('App\Menu');
    }
}
