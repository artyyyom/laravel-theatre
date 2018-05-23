<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
	protected $hidden = [
    	'created_at',
    	'updated_at'
    ];
	protected $fillable = [
		'name',
		'start_date',
		'end_date',
		'isActive'
    ];
    public function seances() {
    	return $this->hasMany('App\Seance');
    }

}
