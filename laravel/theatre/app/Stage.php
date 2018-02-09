<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    public funtion seances() {
    	return $this->hasMany('App\Seance');
    }
}
