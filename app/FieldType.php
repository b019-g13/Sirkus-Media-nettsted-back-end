<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FieldType extends Model
{
    protected $fillable = ['name', 'slug'];

    public $timestamps = false;

    public function fields()
    {
       return $this->hasMany('App\Field');
    }
}
