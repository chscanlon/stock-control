@extends('layouts.master')
@section('content')


<div class="container">

    <h1 class="title">Product Details</h1>

    <h2>{{$product->display_name}} - {{$product->id}}</h2>

    <p>Supplier : {{$product->supplier}}</p>

    <p>barcode : {{$product->barcode}}</p>

    <p>product_range : {{$product->product_range}}</p>

    <p>order_name : {{$product->order_name}}</p>

    <p>supplier_sequence : {{$product->supplier_sequence}}</p>

    <p>discontinued : {{$product->discontinued}}</p>

    <p>product_usage : {{$product->product_usage}}</p>

    <p>reorder_alert_threshold : {{$product->reorder_alert_threshold}}</p>

    <p>current_max_stock : {{$product->current_max_stock}}</p>

    <p>current_stock_available : {{$product->current_stock_available}}</p>

    <p>current_cost_price : {{$product->current_cost_price}}</p>

    <p>current_retail_price : {{$product->current_retail_price}}</p>

    <p>timely_product_status : {{$product->timely_product_status}}</p>

    <p>created_in_stocktake_id : {{$product->created_in_stocktake_id}}</p>

    <p>created_in_stocktake_id : {{$product->deleted_in_stocktake_id}}</p>




    @endsection
