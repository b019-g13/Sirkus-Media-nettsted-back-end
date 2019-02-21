<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use Traits\UsesUuid;

    

    protected $appends = [
        "components"
     ];

    // kobling til pagecomponents
    public function page_components()
    {
        return $this->hasMany('App\PageComponent');
    }
    //  har en menu
    public function menu()
    {
        return $this->hasOne('App\Menu');
    }

    // Kobling til images
    public function image()
    {
        return $this->belongsTo('App\Image', 'image_id');
    }


    
   public function getComponentsAttribute()
   {

      $components = [];
      $page_components = $this->page_components()->get();
      

      foreach ($page_components as $page_component) {
          $push = (object) [
                "id" => $page_component->component->id,
                "name" => $page_component->component->name,
                "slug" => $page_component->component->slug,
                "order" => $page_component->component->order,
                "parent_id"=>$page_component->component->parent_id,
                "fields" => $page_component->component->fields
          ];

          array_push($components, $push);
      }

      return $components;
   }

}
