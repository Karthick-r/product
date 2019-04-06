<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
  


    public function state_allocated()
    {
        return $this->hasmany('App\state_allocate','state_id','id');
    }


}
