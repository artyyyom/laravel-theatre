<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    public funtion seances() {
    	return $this->hasMany('App\Seance');
    }

    public function employees() {
    	return $this->belongsToMany('App\Employee');
    }

}
