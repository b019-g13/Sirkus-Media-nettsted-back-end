<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use Traits\UsesUuid;
    
    // kobling til pagecomponents
    public function page_components()
    {
        return $this->hasMany('App\PageComponent');
    }
    // Tilhører til en menu
    public function menu()
    {
        return $this->hasOne('App\Menu');
    }

    // Kobling til images
    public function image()
    {
        return $this->belongsTo('App\Image', 'image_id');
    }

    public function link()
    {
        return  $this->hasOne('App\Link');
    }
}
