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
            $push = (object) [
                "field_id" => $component_field->field->id,
                "name" => $component_field->field->name,
                "slug" => $component_field->field->slug,
                "type" => $component_field->field->field_type->slug,
                "value" => null
            ];

            array_push($fields, $push);
        }

        return $fields;
    }

    public static function generateFieldsHTML($fields)
    {
        $html_output = '';

        if (empty($fields)) {
            return $html_output;
        }

        foreach ($fields as $field) {
            $html_output .= '<div class="component-field component-field-type-' . $field->type
                         . '" data-field_id="' . $field->field_id . '" data-field_type="' . $field->type . '">';
            $html_output .= '<label>' . $field->name . '</label>';

            if ($field->type == 'string' || $field->type == 'icon') {
                $html_output .= '<input type="text" value="' . $field->value . '">';
            } else if ($field->type == 'hex_color') {
                $html_output .= '<input type="color" value="' . $field->value . '">';
            } else if ($field->type == 'text') {
                $html_output .= '<textarea>' . $field->value . '</textarea>';
            } else if ($field->type == 'image') {
                $html_output .= '<input type="file" value="' . $field->value . '">';
            } else {
                $html_output .= '<input type="text" value="' . $field->value . '">';
            }

            $html_output .= '</div>';
        }

        return $html_output;
    }

    public function getFieldsHTML()
    {
        return self::generateFieldsHTML($this->fields);
    }

    public function getFieldsAndChildrenHTML()
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
