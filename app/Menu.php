<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use Traits\UsesUuid;
    protected $fillable = [
        'name', 'global', 'page_id', 'menu_location_id',
    ];

    //Har flere links
    public function links()
    {
        return $this->hasManyThrough(
            'App\Link',
            'App\MenuLink',
            'menu_id',
            'id',
            'id',
            'link_id'
        )->orderBy('order');
    }

    public function page()
    {
        return $this->belongsTo('App\Page');
    }

    public function menu_location()
    {
        return $this->belongsTo('App\MenuLocation');
    }

    public function menu_links()
    {
        return $this->hasMany('App\MenuLink');
    }

}
