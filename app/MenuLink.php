<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuLink extends Model
{
    use Traits\UsesUuid;

    // 
    public function menu()
    {
        return $this->belongsTo('App\Menu');
    }

    public function link()
    {
        return $this->belongsTo('App\Link');
    }
}
