<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function seance() {
        $this->belongsTo('App\Seance');
    }
    
    public function row_place() {
        $this->belongsTo('App\Row_Place');
    }
    
}
