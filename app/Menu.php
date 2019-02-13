<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
   use Traits\UsesUuid;

    //Har flere links
   public function menu_links()
   {
      return $this->hasMany('App\MenuLink');
   }

    // Tilhører til side
   public function page()
   {
      return $this->belongsTo('App\Page');
   }

   public function menu_location()
   {
      return $this->belongsTo('App\MenuLocation');
   }
}
