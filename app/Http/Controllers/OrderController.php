<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderItem;
use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();
        return view('order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('order.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lorealOrders = $this->getLorealOrderQuery();
        $firstOrder = $lorealOrders->first();
        $newOrder = new Order;
        $newOrder->supplier = $firstOrder->supplier;
        $newOrder->order_date = Carbon::now();
        $newOrder->status = 'Draft';
        $newOrder->item_count = $lorealOrders->count();
        $newOrder->save();

        foreach ($lorealOrders as $lorealOrder) {
            try {
                $product = Product::where('id', $lorealOrder->id)->firstOrFail();

                $orderItem = new OrderItem;
                $orderItem->order()->associate($newOrder);
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

        $orders = Order::all();
        return view('order.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $order->load('orderItems')->orderBy('supplier_sequence');
        return view('order.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        $orders = Order::all();
        return view('order.index', compact('orders'));
    }

    /**
     * Show the form to select stock reports pre and post order check-in.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectOrderCheckIn()
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
