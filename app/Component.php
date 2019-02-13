<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use Traits\UsesUuid;
    
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
}
