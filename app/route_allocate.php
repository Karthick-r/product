<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class route_allocate extends Model
{
    public function route_allocate()
    {
        return $this->hasone('App\Routes','id','route_id');
    }
}
