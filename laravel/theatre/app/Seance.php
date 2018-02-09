<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    public function performance() {
    	return $this->belongsTo('App\Performance');
    }

    public function stage() {
    	return $this->belongsTo('App\Stage');
    }

}
