<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    //Har en link
    public function component_field(){
        $this->hasOne('App\ComponentField');
    }

    // Tilhører til page
    public function page(){
        $this->belongsTo('App\Page', 'page_id');
    }

    // Har flere menus
    public function menus(){
        $this->belongsToMany('App\Menu', 'menu_id');
    }
}
