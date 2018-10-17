<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StocktakeEvent extends Model
{
    //
    public function stocktakes()
    {
        return $this->hasMany('App\Stocktake');
    }

}
