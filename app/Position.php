<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
	protected $hidden = [
    	'created_at',
    	'updated_at'
	];
	protected $fillable = [
        'name', 'order'
    ];
    public function employees() {
    	return $this->belongsToMany('App\Employee', 'employees_positions', 'position_id', 'employee_id');
    }

}
