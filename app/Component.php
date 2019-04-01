<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Component extends Model
{
    use Traits\UsesUuid;
    use HasRoles;

    protected $fillable = [
        'name', 'slug', 'order', 'parent_id'
     ];

    protected $appends = [
        "fields"
    ];
    
    // Kobling til page_components
    public function page_components()
    {
         return $this->hasMany('App\PageComponent');
    }
    // Kobling til component_field
    public function component_fields()
    {
        return $this->hasMany('App\ComponentField');
    }

    // Kobling mellom children og components
    public function parent()
    {
        return $this->belongsTo('App\Component');
    }
    public function children()
    {
        return $this->hasMany('App\Component', 'parent_id');
    }


     
   public function getFieldsAttribute()
   {

      $fields = [];
      $component_fields = $this->component_fields()->get();
      

      foreach ($component_fields as $component_field) {
          $push = (object) [
                "id" => $component_field->field->id,
                "name" => $component_field->field->name,
                "link" => $component_field->field->link,
                "image"=> $component_field->field->image,
          ];

          array_push($fields, $push);
      }

      return $fields;
   }



}
