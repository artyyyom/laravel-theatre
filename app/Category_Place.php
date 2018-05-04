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
    public function rows_places() {
        $this->hasMany('App\Row_Place');
    }
}
