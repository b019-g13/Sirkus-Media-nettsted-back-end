<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use Traits\UsesUuid;
   
    //Har flere links
    public function menu_links(){
      return  $this->belongsTo('App\MenuLink', 'menu_link_id');
    }

    // Kan være i flere pages
    public function pages(){
       return $this->hasMany('App\Page', 'page_id');
    }

    // 
    public function menu_location(){
       return $this->hasOne('App\MenuLocation');
    }
}
