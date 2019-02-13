<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use Traits\UsesUuid;
    
    //Har en link
    public function component_field(){
       return $this->hasOne('App\ComponentField');
    }

    // Tilhører til page
    public function page(){
      return  $this->belongsTo('App\Page', 'page_id');
    }

    // Har flere menus
    public function menu_link(){
      return  $this->hasOne('App\MenuLink');
    }
}
