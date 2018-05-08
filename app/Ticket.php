<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public $incrementing = false;

    protected $hidden = [
    	'created_at',
    	'updated_at'
    ];
    protected $primaryKey = "id";

    protected $fillable = ['id','is_avalaible', 'status', 'user_id'];
    

    public function seance() {
        $this->belongsTo('App\Seance');
    }
    
    public function row_place() {
        $this->belongsTo('App\Row_Place');
    }

    public function user() {
        $this->belongsTo('App\User');
    }
    
}
