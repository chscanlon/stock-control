<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stocktake extends Model
{
    //
    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function stocktakeEvent()
    {
        return $this->belongsTo('App\StocktakeEvent');
    }


}
