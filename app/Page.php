<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use Traits\UsesUuid;

    protected $fillable = [
        'title', 'image_id'
    ];

    // kobling til components
    public function components()
    {
        return $this->hasManyThrough(
            'App\Component',
            'App\PageComponent',
            'page_id',        // page_components.page_id
            'id',             // components.id
            'id',             // page.id
            'component_id'    // page_components.component_id
        );
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
