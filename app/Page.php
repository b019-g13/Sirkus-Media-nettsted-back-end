<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

use App\Field;
use App\Component;
use App\PageComponent;

class Page extends Model
{
    use Traits\UsesUuid;

    protected $fillable = [
        'title', 'image_id'
    ];

    protected $appends = [
        'components'
    ];

    protected function setupComponent(PageComponent $page_component, bool $manipulate_data = false)
    {
        $component = Component::find($page_component->component_id);
        $field = Field::find($page_component->field_id);

        // If we didn't find a field, that means the PageComponent is a wrapper component
        if ($field === null) {
            if ($manipulate_data) {
                $page_component->slug = $component->slug;
            } else {
                $page_component->name = $component->name;
            }

            // Get child components
            $component_children = PageComponent::where([
                'page_id' => $this->id,
                'parent_id' => $page_component->id
            ])->whereNull('field_id')->orderBy('order')->get();

            // Setup child components
            if ($component_children->count() !== 0) {
                $page_component->children = $component_children;

                foreach ($component_children as $component_child) {
                    $component_child = $this->setupComponent($component_child);
                }
            }

            // Get component fields
            $component_fields = PageComponent::where([
                'page_id' => $this->id,
                'parent_id' => $page_component->id
            ])->whereNotNull('field_id')->orderBy('order')->get();

            // Setup component fields
            if ($component_fields->count() !== 0) {
                $page_component->fields = $component_fields;

                foreach ($component_fields as $component_field) {
                    $component_field = $this->setupComponent($component_field);
                }
            }

            // Wrapper components don't have values
            if ($manipulate_data) {
                unset($page_component->value);
            }
        } else {
            // We found a field, that means this PageComponent is just a field
            $page_component->slug = $field->slug;

            if (empty($page_component->value)) {
                if ($page_component->link_id !== null) {
                    $page_component->value = $page_component->link;
                } else if ($page_component->image_id !== null) {
                    $page_component->value = $page_component->image;
                }
            }


            if (!$manipulate_data) {
                $page_component->name = $field->name;
                $page_component->type = $field->field_type->slug;
            }
        }

        // Remove all unnecessary data for front-end
        if ($manipulate_data) {
            unset($page_component->id);
            unset($page_component->parent_id);
            unset($page_component->page_id);
            unset($page_component->image_id);
            unset($page_component->link_id);
            unset($page_component->component_id);
            unset($page_component->field_id);
        }

        return $page_component;
    }

    public function getComponentsAttribute()
    {
        $page_components = PageComponent::where([
            'page_id' => $this->id,
            'parent_id' => null
        ])->orderBy('order')->get();

        foreach ($page_components as $page_component) {
            $page_component = $this->setupComponent($page_component, false);
        }

        return $page_components;
    }

    public function recursivelyCreatePageComponents($component, $parent_component = null)
    {
        PageComponent::component_validator($component)->validate();
        $component = (object) $component;

        // Create a wrapper component
        $wrapper_component = new PageComponent;
        $wrapper_component->component_id = $component->id;
        $wrapper_component->page_id = $this->id;
        $wrapper_component->order = $component->order;

        if ($parent_component !== null) {
            $wrapper_component->parent_id = $parent_component->id;
        }

        $wrapper_component->save();

        // Create the fields
        foreach ($component->fields as $field) {
            PageComponent::field_validator($field)->validate();
            $field = (object) $field;

            $page_component = new PageComponent;
            $page_component->page_id = $this->id;
            $page_component->component_id = $component->id;
            $page_component->field_id = $field->id;
            $page_component->value = $field->value;
            $page_component->parent_id = $wrapper_component->id;
            $page_component->order = $field->order;

            $page_component->save();
        }

        // Create child components
        foreach ($component->children as $child_component) {
            $this->recursivelyCreatePageComponents($child_component, $wrapper_component);
        }
    }

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
}
