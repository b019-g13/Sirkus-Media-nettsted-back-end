<?php

namespace App;

use App\Component;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PageComponent extends Model
{
    use Traits\UsesUuid;

    public $timestamps = false;

    // tilhører til component
    public function component()
    {
        return $this->belongsTo('App\Component', 'component_id');
    }

    public function getFieldAttribute()
    {
        $component_field = ComponentField::find($this->component_field_id);
        $field = null;

        if ($component_field !== null) {
            $field = Field::find($component_field->id);
        }

        return $field;
    }

    // Dette tilhører til page
    public function page()
    {
        return $this->belongsTo('App\Page', 'page_id');
    }

    public function image()
    {
        return $this->hasOne('App\Image', 'id', 'image_id');
    }

    public function link()
    {
        return $this->hasOne('App\Link', 'id', 'link_id');
    }

    // Check if this page component is a child component
    public function is_child()
    {
        return ($this->parent_id !== null);
    }

    public static function component_validator(array $data)
    {
        $component_ids = Component::pluck('id')->toArray();

        return Validator::make($data, [
            'id' => ['required', 'uuid', Rule::in($component_ids)],
            'order' => 'required|integer',
            'fields' => 'present|array',
            'fields.*' => ['required_with:fields', 'array'],
            'children' => 'present|array',
            'children.*' => ['required_with:children', 'array'],
        ]);
    }

    public static function field_validator(array $data)
    {
        $component_fields_ids = ComponentField::pluck('id')->toArray();
        $field_type_slugs = FieldType::pluck('slug')->toArray();

        return Validator::make($data, [
            'component_field_id' => ['required', 'uuid', Rule::in($component_fields_ids)],
            'order' => 'required|integer',
            'type' => ['required', 'string', Rule::in($field_type_slugs)],
            'value' => ['present'],
        ]);
    }

    public function getFieldsAndChildrenHTML()
    {
        // $field = $component_field->field;
        // $field_type = $field->field_type->slug;
        // if ($field_type === 'string') {
        // }

        $html_output = '<div class="page-component" data-component_id="' . $this->component_id . '">';
        $html_output .= '<span class="heading">' . $this->name . '</span>';
        $html_output .= Component::generateFieldsHTML($this->fields);

        if (isset($this->children)) {
            foreach ($this->children as $child_component) {
                $html_output .= $child_component->getFieldsAndChildrenHTML();
            }
        }

        if ($this->is_child()) {
            $html_output .= $this->order;
            $html_output .= '<div class="page-component-actions">';
            $html_output .= '<button class="page-component-duplicate" type="button">Legg til</button>';
            $html_output .= '<button class="page-component-remove" type="button">Fjern</button>';
            $html_output .= '</div>';
        }

        $html_output .= '</div>';

        return $html_output;
    }
}
