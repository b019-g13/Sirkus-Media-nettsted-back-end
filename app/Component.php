<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    // Kobling til pages
    public function pages(){
        return $this->belomgsToMany('App\Page', 'page_id');
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
