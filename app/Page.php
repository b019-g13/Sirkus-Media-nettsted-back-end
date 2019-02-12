<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use Traits\UsesUuid;
    
    // kobling til pagecomponents
    public function pagecomponents(){
        return $this->hasMany('App\PageComponent', 'page_component_id');
    }
    // Tilhører til en menu
    public function menu(){
        return $this->belongsTo('App\Menu');
    }

    // Kobling til images
    public function images(){
        return $this->hasMany('App\Image', 'image_id');
    }

    // Kobling til flere links
    public function links(){
        $this->hasMany('App\Link');
    }
}
