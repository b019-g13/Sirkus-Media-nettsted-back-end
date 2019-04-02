<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Field extends Model
{
    use Traits\UsesUuid;
 
    protected $fillable = ['name', 'slug'];

    //Kobling til component_field
    public function component_fields()
    {
       return $this->hasMany('App\ComponentField');
    }

    public function field_type()
    {
       return $this->belongsTo('App\FieldType');
    }
}
