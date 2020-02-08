<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderItem;
use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;

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

    // - - - - - - - CUSTOM FUNCTIONS - - - - - - - - -

    /**
     * Update the status of the specified order to confrimed.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function confirmOrder(Order $order)
    {
        $order->status = 'Confirmed';
        $order->save();
        $orders = Order::all();
        return view('order.index', compact('orders'));
    }

    /**
     * Show the form to select stock reports pre and post order check-in.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectOrderCheckIn(Order $order)
    {
        return view('order.check-in', compact('order'));
    }


    public function processOrderCheckIn(Request $request, $id)
    {
        $order = Order::where('id', $id)->firstOrFail();

        $order->stock_before_file_path = $request->file('stockBeforeOrderUpdate')->store('stocktakes');
        $order->stock_after_file_path = $request->file('stockAfterOrderUpdate')->store('stocktakes');
        $itemsDeliveredNotOrdered = $order->setDeliveredItemCount();

        return view('order.delivery', compact('itemsDeliveredNotOrdered', 'order'));
    }

    public function exportPdf(Request $request, $id)
    {
        $order = Order::where('id', $id)->firstOrFail();

        // Send data to the view using loadView function of PDF facade
        $pdf = PDF::loadView('order.pdf', compact('order'));

        // If you want to store the generated pdf to the server then you can use the store function
        //$pdf->save(storage_path().'_filename.pdf');

        // Finally, you can download the file using download function
        return $pdf->download('order.pdf');
    }


    protected function getLorealOrderQuery()
    {
        $query =  Product::select(DB::raw('id, supplier, product_range, display_name, current_max_stock, current_stock_available, (current_max_stock - current_stock_available) AS ORDER_AMOUNT'))
                            ->where([['timely_product_status', 'active'], ['supplier', "L'Oreal"], ['discontinued', false]])
                            ->having('ORDER_AMOUNT', '>', 0)
                            ->orderBy('supplier_sequence')
                            ->get();
        return $query;
    }
}
