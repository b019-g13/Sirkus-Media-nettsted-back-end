<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $appends = [
        'url_full',
    ];

    use Traits\UsesUuid;

    // kobling til user
    public function user()
    {
        return $this->hasOne('App\User');
    }

    // Kobling til image_sizes
    public function image_size()
    {
        return $this->hasOne('App\ImageSize');
    }

    public function getUrlFullAttribute()
    {
        return asset('storage/' . $this->url);
    }
}
