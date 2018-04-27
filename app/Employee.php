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
        return $this->belongsToMany('App\Performance', 'performances_employees', 'employee_id',  'performance_id')
            ->withPivot('role', 'role');
    }

    public function positions() {
        return $this->belongsToMany('App\Position', 'employees_positions', 'employee_id',  'position_id');
    }

    public function unit() {
        return $this->belongsTo('App\Unit');
    }

}