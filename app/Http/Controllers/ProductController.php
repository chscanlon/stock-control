<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
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
        $products = Product::all();
        $productRanges = $products->sortBy('product_range')->pluck('product_range')->unique();
        $productUses = $products->sortBy('product_usage')->pluck('product_usage')->unique();
        $suppliers = $products->sortBy('supplier')->pluck('supplier')->unique();

        return view('product.index', compact('productRanges', 'productUses', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('product.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function orderHistory(Request $request)
    {

        $selectedRange = $request->input('selectedRange', 'Dia Light');

        Log::info($request->input('selectedRange'));

        $products = Product::select('id', 'display_name', 'supplier_sequence', 'product_range', 'current_max_stock')
            ->where([['product_range', $selectedRange], ['timely_product_status', 'active'], ['supplier', "L'Oreal"], ['discontinued', false]])
            ->orderby('supplier_sequence')
            ->get();

        $productRanges = Product::where([['timely_product_status', 'active'], ['supplier', "L'Oreal"], ['discontinued', false]])
            ->orderBy('product_range')
            ->pluck('product_range')
            ->unique();

        $orders = Order::orderBy('created_at', 'desc')->limit(10)->get();
        $orderCount = Order::orderBy('created_at', 'desc')->limit(10)->get()->count();
        $productOrders = array();
        $productCounter = 0;

        foreach ($products as $product) {
            $poh = array();
            //$poh += ['product_id' => $product->id];
            $poh += ['Range' => $product->product_range];
            //$poh += ['supplier_sequence' => $product->supplier_sequence];
            $poh += ['Name' => $product->display_name];
            $orderTotal = 0;

            foreach ($orders as $order) {
                //$poh = $poh . '"order_id" => "' . $order->id . '",';
                //$poh = $poh . '"order_date" => "' . $order->order_date . '",';

                $dt = new Carbon($order->order_date);
                $orderedProduct = $order->orderItems()->where('product_id', $product->id)->first();

                if (is_null($orderedProduct)) {
                    //$poh += [ '"' . $dt->format('Ymd') . '"' => 0];
                    $poh += [$dt->format('d-m-Y') => 0];
                } else {
                    //$poh += [ '"' . $dt->format('Ymd') . '"' => $orderedProduct->order_amount];
                    $poh += [$dt->format('d-m-Y') => $orderedProduct->order_amount];
                    $orderTotal = $orderTotal + $orderedProduct->order_amount;
                }

            }

            $avgOrder = $orderTotal / $orderCount;

            $poh += ['Total' => $orderTotal];

            $poh += ['Avg' => $avgOrder];

            $poh += ['Restock' => $product->current_max_stock];

            if ($productCounter == 0) {
                $keys = array_keys($poh);
            }

            $productCounter++;

            array_push($productOrders, $poh);
        }
        //dd($keys);

        $keys = collect($keys);
        $productOrders = collect($productOrders);
        //$productRanges = collect($productRanges);
        //dd($productRanges);

        return view('report.summary', compact('productRanges', 'keys', 'productOrders'));
    }
}
