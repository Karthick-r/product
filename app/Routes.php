<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Routes extends Model
{
   
    public function Route_District1()
    {
        return $this->hasone('App\District','id','district_id');
    }



    public function Route_user()
    {
        return $this->hasone('App\User','id','user_id');
    }



    public function Route_shop()
    {
        return $this->hasmany('App\Stores','route_id','id');
    }


    public function route_contry()
    {
        return $this->hasone('App\Country','id','country_id');
    }


    public function route_atten()
    {
        return $this->hasmany('App\store_attendance','route_id','id');
    }

    public function route_allocated()
    {
        return $this->hasone('App\route_allocate','route_id','id');
    }


}
