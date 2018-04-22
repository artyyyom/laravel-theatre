<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
	protected $hidden = [
    	'created_at',
    	'updated_at'
    ];

    public function performances() {
    	return $this->hasMany('App\Performance');
    }

}
