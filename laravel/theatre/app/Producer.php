<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producer extends Model
{
    public function performances() {
    	return $this->belongsToMany('App\Performances');
    }
}
