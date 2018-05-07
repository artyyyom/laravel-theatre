<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $hidden = [
    	'created_at',
    	'updated_at'
    ];
    protected $fillable = ['is_avalaible', 'status'];
    public function seance() {
        $this->belongsTo('App\Seance');
    }
    
    public function row_place() {
        $this->belongsTo('App\Row_Place');
    }
    
}
