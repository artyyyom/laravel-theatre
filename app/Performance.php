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
    protected $fillable = [
        'name', 'genre', 'duration', 'description', 'author', 'age_restrict', 'photo_main', 'photos'
    ];
    public function employees() {
    	return $this->belongsToMany('App\Employee', 'performances_employees', 'performance_id', 'employee_id')
            ->withPivot('role', 'role');
    }

    

}
