<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use Traits\UsesUuid;
    
    // Kobling til pages
    public function page_components(){
         return $this->hasMany('App\PageComponent', 'page_component_id');
    }
    // Kobling til component_fields
    public function fields(){
        return $this->belongsToMany('App\Field', 'field_id');
    }

    // Kobling mellom children og components
    public function parent(){
        return $this->belongsTo('App\Component', 'parent_id');
    }
    public function children(){
        return $this->hasMany('App\Component', 'parent_id' );
    }
}
