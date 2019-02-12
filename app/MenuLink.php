<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuLink extends Model
{
    use Traits\UsesUuid;
    
    //
    public function menu(){
        return $this->belongsTo('App\Menu', 'menu_id');
    }

    public function link(){
        return $this->hasMany('App\Link', 'link_id');
    }
}
