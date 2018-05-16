<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category_Place extends Model
{
    protected $table = 'category_places';
    protected $hidden = [
    	'created_at',
    	'updated_at'
    ];
    protected $fillable = [
        'name'
    ];

    public function rows_places() {
        return $this->hasMany('App\Row_Place');
    }
    public function tickets() {
        return $this->hasMany('App\Ticket');
    }
}
