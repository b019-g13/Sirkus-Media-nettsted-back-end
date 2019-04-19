<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use Traits\UsesUuid;

    protected $fillable = ['name', 'value', 'page_id'];

    public function page()
    {
        return $this->belongsTo('App\Page');
    }

    public function getValueAttribute($value)
    {
        if ($this->page_id === null) {
            return $value;
        }

        return $this->page;
    }
}
