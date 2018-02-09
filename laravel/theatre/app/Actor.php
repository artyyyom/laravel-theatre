<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    public function performances() {
    	return $this->belongsToMany('App\Performances');
    }
}
