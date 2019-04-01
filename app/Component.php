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
                "type" => $component_field->field->field_type->slug,
                "value" => $value
            ];

            array_push($fields, $push);
        }

        return $fields;
    }

    function getFieldsHTML()
    {
        $html_output = '';

        foreach ($this->fields as $field) {
            $html_output .= '<div class="component-field" data-field_id="' . $field->id . '">';
            $html_output .= '<label>' . $field->name . '</label>';

            if ($field->type == 'string' || $field->type == 'icon') {
                $html_output .= '<input type="text">';
            } else if ($field->type == 'hex_color') {
                $html_output .= '<input type="color">';
            } else if ($field->type == 'text') {
                $html_output .= '<textarea></textarea>';
            } else if ($field->type == 'image') {
                $html_output .= '<input type="file">';
            } else {
                $html_output .= '<input type="text">';
            }



            $html_output .= '</div>';
        }

        return $html_output;
    }

    function getFieldsAndChildrenHTML()
    {
        $html_output = '<div class="page-component" data-component_id="' . $this->id . '">';
        $html_output .= '<span class="heading">' . $this->name . '</span>';
        $html_output .= $this->getFieldsHTML();

        foreach ($this->children as $child_component) {
            $html_output .= $child_component->getFieldsAndChildrenHTML();
        }

        $html_output .= '</div>';

        return $html_output;
    }
}
