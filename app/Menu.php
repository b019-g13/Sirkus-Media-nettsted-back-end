<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use Traits\UsesUuid;
   
    //Har flere links
    public function links(){
        $this->belongsToMany('App\Link', 'link_id');
    }

    // Kan være i flere pages
    public function pages(){
        $this->hasMany('App\Page', 'page_id');
    }

    // 
    public function menu_location(){
        $this->hasOne('App\MenuLocation');
    }
}
