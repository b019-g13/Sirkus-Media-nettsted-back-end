<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageComponent extends Model
{
    use Traits\UsesUuid;

    // tilhører til component
    public function component(){
        return $this->belongsTo('App\Component', 'component_id');
    }

    // Dette tilhører til page
    public function page(){
        return $this->belongsTo('App\Page', 'page_id');
    }
}
