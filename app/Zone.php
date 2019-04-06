<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
   
    public function Zone()
    {
        return $this->hasone('App\State','id','state_id');
    }

  

}
