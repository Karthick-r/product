<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
   
   
    public function store_contry()
    {
        return $this->hasone('App\Country','id','country_id');
    }

      public function store_atten()
    {
        return $this->hasmany('App\store_attendance','store_id','id' );
    }

    //
}
