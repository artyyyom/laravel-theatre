<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
	protected $hidden = [
    	'created_at',
    	'updated_at'
    ];
    
    public function performances() {
    	return 'hello';//$this->belongsToMany('App\Performance');
    }

    public function position() {
    	return $this->belongsTo('App\Position');
    }
}