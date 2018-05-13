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
        return $this->belongsTo('App\Seance');
    }
    
    public function row_place() {
        return $this->belongsTo('App\Row_Place');
    }

    public function category_place() {
        return $this->belongsTo('App\Category_Place', 'category_id');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
    
}
