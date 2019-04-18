<?php

namespace App;

use App\ComponentField;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use Traits\UsesUuid;

    protected $fillable = [
        'name', 'slug', 'parent_id',
    ];

    protected $appends = [
        "fields",
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
            'component_id' => $this->id,
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
            $field = $component_field->field;
            $field_type = $field->field_type->slug;

            $nickname = $component_field->nickname;

            if (empty($component_field->nickname)) {
                $nickname = $field->name;
            }

            $push = (object) [
                "component_field_id" => $component_field->id,
                "field_id" => $field->id,
                "name" => $field->name,
                "nickname" => $nickname,
                "slug" => $field->slug,
                "type" => $field_type,
                "value" => null,
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
            . '" data-component_field_id="' . $field->component_field_id . '" data-field_type="' . $field->type . '">';
            $html_output .= '<label>' . $field->nickname . '</label>';

            if ($field->type == 'string' || $field->type == 'icon') {
                $html_output .= '<input class="cf-input" type="text" value="' . $field->value . '">';
            } else if ($field->type == 'hex_color') {
                $html_output .= '<input class="cf-input" type="color" value="' . $field->value . '">';
            } else if ($field->type == 'text') {
                $html_output .= '<textarea class="cf-input">' . $field->value . '</textarea>';
            } else if ($field->type == 'image') {
                $id = null;
                $url = null;

                if (!empty($field->value)) {
                    $id = $field->value->id;
                    $url = asset('storage/' . $field->value->url);
                }

                $html_output .= '<div class="cf-media-picker" data-value="' . $url . '">';
                $html_output .= '<button class="mp-trigger-open" type="button">Velg bilde</button>';
                $html_output .= '<button class="mp-trigger-delete" type="button">Fjern bilde</button>';
                $html_output .= '<input class="cf-input" value="' . $id . '" type="text">';
                $html_output .= '</div>';
            } else {
                $html_output .= '<input class="cf-input" type="text" value="' . $field->value . '">';
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

        if (!empty($this->children)) {
            $html_output .= '<ul class="drag-area drag-area-destination">';
            foreach ($this->children as $child_component) {
                $html_output .= '<li class="draggable">';
                $html_output .= $child_component->getFieldsAndChildrenHTML();
                $html_output .= '</li>';
            }
            $html_output .= '</ul>';
        }

        $html_output .= '<div class="page-component-actions">';
        $html_output .= '<button class="page-component-duplicate" type="button">+</button>';
        $html_output .= '<button class="page-component-remove" type="button">-</button>';
        $html_output .= '</div>';

        $html_output .= '</div>';

        return $html_output;
    }
}
