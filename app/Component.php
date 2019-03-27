<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Link;
use App\Image;
use App\ComponentField;

class Component extends Model
{
    use Traits\UsesUuid;

    protected $fillable = [
        'name', 'slug', 'parent_id'
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
    public function getComponentFieldsAttribute()
    {
        $comp_fields = ComponentField::where([
            'component_id' => $this->id
        ])->get();

        return $comp_fields;
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

        foreach ($this->component_fields->sortBy('order') as $component_field) {
            $value = $component_field->value;

            if ($component_field->link_id !== null) {
                $value = $component_field->link;
            } else if ($component_field->image_id !== null) {
                $value = $component_field->image;
            }

            $push = (object) [
                "id" => $component_field->field->id,
                "name" => $component_field->field->name,
                "slug" => $component_field->field->slug,
                "value" => $value
            ];

            array_push($fields, $push);
        }

        return $fields;
    }
}
