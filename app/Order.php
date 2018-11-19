<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    public function orderItems()
    {
        return $this->hasMany('App\OrderItem');
    }

    public function delete()
    {
        // delete all related orderItems
        $this->orderItems()->delete();

        // delete the user
        return parent::delete();
    }
}
