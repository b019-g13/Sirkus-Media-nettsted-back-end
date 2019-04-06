<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuLocation extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'slug'];
    
    // Har bare en menu
    public function menu()
    {
       return $this->hasOne('App\Menu');
    }
}
