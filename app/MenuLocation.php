<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

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
