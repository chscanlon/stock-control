<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $guarded = ['id'];

    protected $appends = ['stock_before_check_in', 'stock_after_check_in'];

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

    /**
     * Get the stock_before_check_in array for the order.
     *
     * @return array
     */
    public function getStockBeforeCheckInAttribute()
    {
        return $this->attributes['stock_before_check_in'];
    }

    /**
     * Set the stock_before_check_in array for the order.
     *
     * @param  array  $stockList
     * @return void
     */
    public function setStockBeforeCheckInAttribute($path)
    {
        $stockList = $this->importTimelyStockLevelReport($path);
        $this->attributes['stock_before_check_in'] = $stockList;
    }

    /**
     * Get the stock_after_check_in array for the order.
     *
     * @return array
     */
    public function getStockAfterCheckInAttribute()
    {
        return $this->attributes['stock_after_check_in'];
    }

    /**
     * Set the stock_after_check_in array for the order.
     *
     * @param  array  $stockList
     * @return void
     */
    public function setStockAfterCheckInAttribute($path)
    {
        $stockList = $this->importTimelyStockLevelReport($path);
        $this->attributes['stock_after_check_in'] = $stockList;
    }

    /**
     * Update orderItems with delivered amount.
     *
     * @return void
     */
    public function setDeliveredItemCount()
    {

      //get the key/value pairs in $stockBeforeArray that are not identical in $stockAfterArray
      $orderedProducts = $this->getStockBeforeCheckInAttribute()->diffAssoc($this->getStockAfterCheckInAttribute());

      //For each item in $orderedProducts modify the item count to be $stockAfterCount - $stockBeforeCount
      $orderedProducts->transform(function ($item, $key) {
          $stockAfterCount = $this->getStockAfterCheckInAttribute()->get($key);
          return $stockAfterCount - $item;
      });

      foreach ($this->orderItems as $orderItem) {
        $orderItem ['delivered_amount'] = $orderedProducts->get($orderItem->display_name);
        $orderItem->save();
      }

    }

    /**
     * Set the stock_after_check_in array for the order.
     *
     * @param  array  $stockList
     * @return void
     */
     protected function importTimelyStockLevelReport($path)
     {
         $deleted = DB::delete('delete from stock_level_import');
         //echo "records deleted from stock_level_import : " . $deleted;

         $qs = "LOAD DATA LOCAL INFILE '../storage/app/" . $path . "'
                   INTO TABLE stock_level_import
                   FIELDS TERMINATED BY ','
                   OPTIONALLY ENCLOSED BY '\"'
                   LINES TERMINATED BY '\r\n'
                   IGNORE 4 LINES";

         $query = $qs;

         DB::connection()->getpdo()->exec($query);

         $stock = DB::table('stock_level_import')->select('ProductName', 'StockAvailable')->get();

         return $stock->mapWithKeys(function ($item) {
             return [$item->ProductName => $item->StockAvailable];
         });
     }
}
