<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use Traits\UsesUuid;

    protected $fillable = [
        'name', 'global', 'page_id', 'menu_location_id',
    ];

    public $appends = [
        'menu_location',
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

    public function getMenuLocationAttribute()
    {
        return MenuLocation::find($this->menu_location_id);
    }

    public function menu_links()
    {
        return $this->hasMany('App\MenuLink');
    }

}
