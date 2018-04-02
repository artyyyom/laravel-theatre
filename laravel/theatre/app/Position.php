<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
	protected $hidden = [
    	'created_at',
    	'updated_at'
    ];
    public function employees() {
    	return $this->hasMany('App\Employee');
    }

}
