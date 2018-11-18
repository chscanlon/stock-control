<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Product;
use App\Order;
use App\OrderItem;

class OrdersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected $stockAfterArray;

    public function index(Request $request)
    {
        $orders = Order::all();

        return view('order.order-management', compact('orders'));
    }

    public function detail($id)
    {
        $order = Order::find($id);
        $order->load('orderItems')->orderBy('supplier_sequence');

        return view('order.detail', compact('order'));
    }


    public function orderCheckIn(Request $request)
    {
        return view('order.check-order');
    }

    public function processOrderCheckIn(Request $request)
    {
        $path = $request->file('stockBeforeOrderUpdate')->store('stocktakes');
        $stockBeforeArray = $this->importTimelyStockLevelReport($path);

        $path = $request->file('stockAfterOrderUpdate')->store('stocktakes');
        $this->stockAfterArray = $this->importTimelyStockLevelReport($path);

        $orderedProducts = $stockBeforeArray->diffAssoc($this->stockAfterArray);
        //dd($orderedProducts->all());

        $orderedProducts->transform(function ($item, $key) {
            $stockAfterCount = $this->stockAfterArray->get($key);
            return $stockAfterCount - $item;
        });

        dd($orderedProducts->all());
    }

    public function createLorealOrder(Request $request)
    {
        $lorealOrders = $this->getLorealOrderQuery();
        return view('order.loreal-order', compact('lorealOrders'));
    }

    public function confirmLorealOrder(Request $request)
    {
        // this function should....
        // save the order as new records into the orders and order_items tables
        // create and save a pdf that describes the order in sufficient detail to email to the supplier
        // return the user to the order view (this should include a list of active / in-flight orders)

        $lorealOrders = $this->getLorealOrderQuery();
        $firstOrder = $lorealOrders->first();
        $order = new Order;
        $order->supplier = $firstOrder->supplier;
        $order->order_date = Carbon::now();
        $order->status = 'new';
        $order->item_count = $lorealOrders->count();
        $order->save();

        foreach ($lorealOrders as $lorealOrder) {
            try {
                $product = Product::where('id', $lorealOrder->id)->firstOrFail();

                $orderItem = new OrderItem;
                $orderItem->order()->associate($order);
                $orderItem->product()->associate($product);
                $orderItem->supplier = $product->supplier;
                $orderItem->display_name = $product->display_name;
                $orderItem->supplier_product_name = $product->order_name;
                $orderItem->supplier_sequence = $product->supplier_sequence;
                $orderItem->max_stock = $product->current_max_stock;
                $orderItem->available_stock = $product->current_stock_available;
                $orderItem->order_amount = $lorealOrder->ORDER_AMOUNT;
                $orderItem->cost_price = $product->current_cost_price;
                $orderItem->total_price = ($product->current_cost_price * $lorealOrder->ORDER_AMOUNT);
                $orderItem->save();
            } catch (Exception $e) {
                echo 'Message : ' . $e->getMessage() . PHP_EOL;
            }
        }

        dd($lorealOrders);
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


    protected function getLorealOrderQuery()
    {
        $query =  Product::select(DB::raw('id, supplier, product_range, display_name, current_max_stock, current_stock_available, (current_max_stock - current_stock_available) AS ORDER_AMOUNT'))
                            ->where([['supplier', "L'Oreal"], ['discontinued', false]])
                            ->having('ORDER_AMOUNT', '>', 0)
                            ->orderBy('supplier_sequence')
                            ->get();
        return $query;
    }
}
