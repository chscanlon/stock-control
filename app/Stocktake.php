<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stocktake extends Model
{

  public function stocktakeItems()
  {
      return $this->hasMany('App\StocktakeItem');
  }

}
