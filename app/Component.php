<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use Traits\UsesUuid;
    
    // Kobling til page_components
    public function page_component(){
         return $this->hasOne('App\PageComponent');
    }
    // Kobling til component_field
    public function component_field(){
        return $this->hasOne('App\ComponentField');
    }

    // Kobling mellom children og components
    public function parent(){
        return $this->belongsTo('App\Component');
    }
    public function children(){
        return $this->hasMany('App\Component', 'parent_id' );
    }
}
