<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
	protected $hidden = [
    	'created_at',
    	'updated_at'
    ];

    protected $fillable = [
        'date', 'time', 'performance_id', 'stage_id', 'season_id', 'datetime'
    ];
    public function season() {
        return $this->belongsTo('App\Season');
    }

    public function performance() {
    	return $this->belongsTo('App\Performance');
    }

    public function stage() {
    	return $this->belongsTo('App\Stage');
    }
    
    public function tickets() {
        return $this->hasMany('App\Ticket');
    }

}
