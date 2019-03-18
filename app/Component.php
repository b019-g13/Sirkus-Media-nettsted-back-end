<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use Traits\UsesUuid;

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
                "slug" => $component_field->field->slug,
                "value" => $component_field->field->value,
                "link" => $component_field->field->link,
                "image"=> $component_field->field->image,
            ];

            array_push($fields, $push);
        }

      return $fields;
   }
}
