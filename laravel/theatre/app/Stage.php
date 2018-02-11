<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    public function seances() {
    	return $this->hasMany('App\Seance');
    }
}
