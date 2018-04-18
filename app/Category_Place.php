<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category_Place extends Model
{
    public function rows_places() {
        $this->hasMany('App\Row_Place');
    }
}
