<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    public function stocktakes()
    {
        return $this->hasMany('App\Stocktake');
    }

    protected $fillable = ['supplier', 'barcode', 'product_range', 'display_name', 'order_name', 'product_use', 'max_stock', 'current_cost_price', 'current_retail_price'];


}
