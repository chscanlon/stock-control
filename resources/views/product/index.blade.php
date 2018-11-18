@extends('layouts.master')
@section('content')

<div class="container">

    <h1 class="title">Products</h1>

    <table class="table table-sm">
        <tr>
            <th>Use</th>
            <th>Supplier</th>
            <th>Display Name</th>
            <th>Max Stock</th>
            <th>Available Stock</th>
            <th>Action</th>
        </tr>

        @foreach ($products as $product)

        <tr>
            <td> {{$product->product_usage}} </td>
            <td> {{$product->supplier}} </td>
            <td> {{$product->display_name}} </td>
            <td> {{$product->current_max_stock}} </td>
            <td> {{$product->current_stock_available}} </td>
            <td> <a class="btn btn-primary" href="/products/{{$product->id}}" role="button">Show</a> </td>
        </tr>

        @endforeach

    </table>


</div>


@endsection
