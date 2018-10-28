<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StocktakeItem extends Model
{

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function stocktake()
    {
        return $this->belongsTo('App\Stocktake');
    }

}
