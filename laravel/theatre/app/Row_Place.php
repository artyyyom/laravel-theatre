<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Row_Place extends Model
{
    protected $table = 'rows_places';
    public function stage() {
    	return $this->belongsTo('App\Stage');
    }
    
    public function category_place() {
        return $this->belongsTo('App\Category_Place');
    }
    
    public function tickets() {
        return $this->hasMany('App\Ticket');
    }
}
