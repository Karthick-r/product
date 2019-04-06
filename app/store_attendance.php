<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class store_attendance extends Model
{
    public function route_contry()
    {
        return $this->hasone('App\Country','id','country_id');
    }

    public function Store_name()
    {
        return $this->hasone('App\Stores','id','store_id');
    }
}
