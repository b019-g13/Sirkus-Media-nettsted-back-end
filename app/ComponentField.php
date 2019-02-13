<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComponentField extends Model
{   
    use Traits\UsesUuid;

    // tilkobling til ett image
    public function image()
    {
       return  $this->belongsTo('App\image');
    }

    // Kobling til en link
    public function link()
    {
       return $this->belongsTo('App\Link');
    }

    public function component(){
      return $this->belongsTo('App\Component');
   }
   public function field(){
      return $this->belongsTo('App\Field');
   }
}
