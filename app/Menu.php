<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
   use Traits\UsesUuid;

    //Har flere links
   public function menu_link()
   {
      return $this->hasOne('App\MenuLink');
   }

    // Kan være i flere pages
   public function page()
   {
      return $this->belongsTo('App\Page');
   }

    //
   public function menu_location()
   {
      return $this->belongsTo('App\MenuLocation');
   }
}
