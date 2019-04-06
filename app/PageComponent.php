<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

use App\Field;
use App\Component;

class PageComponent extends Model
{
    use Traits\UsesUuid;

    // tilhører til component
    public function component()
    {
        return $this->belongsTo('App\Component', 'component_id');
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

    public static function component_validator(array $data)
    {
        $field_ids = Field::pluck('id')->toArray();
        $component_ids = Component::pluck('id')->toArray();

        return Validator::make($data, [
            'id' => ['required', 'uuid', Rule::in($component_ids)],
            'order' => 'required|integer',
            'fields' => 'present|array',
            'fields.*.id' => ['required_with:fields', 'uuid', Rule::in($field_ids)],
            'fields.*.order' => 'required_with:fields|integer',
            // 'fields.*.value' => ['required_with:fields'],
            'children' => 'present|array',
            'children.*' => ['required_with:children', 'array']
        ]);
    }


    public function getFieldsAndChildrenHTML()
    {
        $html_output = '<div class="page-component" data-component_id="' . $this->component_id . '">';
        $html_output .= '<span class="heading">' . $this->name . '</span>';
        $html_output .= Component::generateFieldsHTML($this->fields);

        if (isset($this->children)) {
            foreach ($this->children as $child_component) {
                $html_output .= $child_component->getFieldsAndChildrenHTML();
            }
        }

        $html_output .= '</div>';

        return $html_output;
    }
}
