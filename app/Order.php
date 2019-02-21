<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $guarded = ['id'];

    protected $stockListAfter;

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
     * Based on Timely stock level reports taken before and after order check in, calculate which and how many items have been delivered. Update the relevant orderItem->delivered_amount with this value.
     *
     * @return array
     */
    public function setDeliveredItemCount()
    {
        $stockListBefore = $this->importTimelyStockLevelReport($this->stock_before_file_path);
        $this->stockListAfter = $this->importTimelyStockLevelReport($this->stock_after_file_path);

        //get the key/value pairs in $stockListBefore that are not identical in stockListAfter
        $receivedProducts = $stockListBefore->diffAssoc($this->stockListAfter);

        //For each item in $orderedProducts modify the item count to be $stockAfterCount - $stockBeforeCount
        $receivedProducts->transform(
                function ($item, $key) {
                    $stockAfterCount = $this->stockListAfter->get($key);
                    return $stockAfterCount - $item;
                }
              );
        //dd($receivedProducts);

        $orderedProducts = $this->orderItems->mapWithKeys(function ($item) {
            return [$item['display_name'] => $item['order_amount']];
        });
        //dd($orderedProducts);

        //get the key/value pairs in $receivedProducts that do not exist in $orderedProducts
        $deliveredNotOrderedProducts = $receivedProducts->diffKeys($orderedProducts);

        foreach ($this->orderItems as $orderItem) {
            $orderItem->delivered_amount = 0;
            if (is_numeric($receivedProducts->get($orderItem->display_name))) {
              $orderItem->delivered_amount = $receivedProducts->get($orderItem->display_name);
            }
            $orderItem->save();
        }

        //$this->status = 'Received';
        $this->save();

        return $deliveredNotOrderedProducts;
    }

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
