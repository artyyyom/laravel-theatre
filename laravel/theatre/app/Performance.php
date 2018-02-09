<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    public funtion seances() {
    	return $this->hasMany('App\Seance');
    }

    public function actors() {
    	return $this->belongsToMany('App\Actor');
    }

    public function producers() {
    	return $this->belongsToMany('App\Producer');
    }
}
