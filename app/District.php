<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public function District_Zone()
    {
        return $this->hasone('App\Zone','id','zone_id');
    }

   

}
