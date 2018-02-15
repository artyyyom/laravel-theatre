<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    public function seances() {
    	return $this->hasMany('App\Seance');
    }
    
    public function rows_places() {
        return $this->hasMany('App\Row_Place');
    }
}
