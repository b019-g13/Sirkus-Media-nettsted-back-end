<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    // kobling til components
    public function components(){
        return $this->belongsToMany('App\Component', 'component_id');
    }
    // Tilhører til en menu
    public function menu(){
        $this->belongsTo('App\Menu');
    }

    // Kobling til images
    public function images(){
        $this->hasMany('App\Image', 'image_id');
    }

    // Kobling til flere links
    public function links(){
        $this->hasMany('App\Link');
    }
}
