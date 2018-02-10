<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function performances() {
    	return $this->belongsToMany('App\Performances');
    }

    public function positions() {
    	return $this->belongsTo('App\Positions');
    }
}