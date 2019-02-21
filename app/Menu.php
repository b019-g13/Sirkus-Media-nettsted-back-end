<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
   use Traits\UsesUuid;

   protected $appends = [
      "links",
      "locations"
   ];

    //Har flere links
   public function menu_links(){
      return $this->hasMany('App\MenuLink');
   }

    
   public function page()
   {
      return $this->belongsTo('App\Page');
   }

   public function menu_location()
   {
      return $this->belongsTo('App\MenuLocation');
   }

   // Link attributes
   public function getLinksAttribute()
   {

      $links = [];
      $menu_links = $this->menu_links()->get();

      foreach ($menu_links as $menu_link) {
          $push = (object) [
              "name" => $menu_link->link->name,
              "value" => $menu_link->link->value
          ];

          array_push($links, $push);
      }

      return $links;
   }

// Menu_location attribute
   public function getLocationsAttribute()
   {

      $locations = [];
      $menu_location = $this->menu_location()->get();

      foreach ($menu_location as $location) {
          $push = (object) [
              "name" => $location->name,
              "slug" => $location->slug
          ];

          array_push($locations, $push);
      }

      return $locations;
   }
}
