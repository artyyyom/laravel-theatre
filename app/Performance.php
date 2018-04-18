<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
	protected $hidden = [
    	'created_at',
    	'updated_at'
    ];

    public function seances() {
    	return $this->hasMany('App\Seance');
    }

    public function employees() {
    	return $this->belongsToMany('App\Employee', 'performances_employees', 'performance_id', 'employee_id');
    }

}
