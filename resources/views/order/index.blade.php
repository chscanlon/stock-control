@extends('layouts.master')
@section('content')


<div class="container">

    <h1 class="title">Orders</h1>

    <div class="row my-2">
        <div class="col">
            <a class="btn btn-primary" href="/orders/create" role="button">New Order</a>
        </div>
    </div>

    <table class="table table-sm">
        <tr>
            <th>Order Id</th>
            <th>Supplier</th>
            <th>Order Date</th>
            <th>Status</th>
            <th>Item Count</th>
            <th>Action</th>
        </tr>

        @foreach ($orders as $order)

        <tr>
            <td> {{$order->id}} </td>
            <td> {{$order->supplier}} </td>
            <td> {{$order->order_date}} </td>
            <td> {{$order->status}} </td>
            <td> {{$order->item_count}} </td>
            <td>
              <a class="btn btn-primary" href="/orders/{{$order->id}}" role="button">Show</a>
            @if ($order->status = 'Draft')
              <a class="btn btn-primary" href="/orders/{{$order->id}}" role="button">Delete</a>
            @endif
            </td>
        </tr>

        @endforeach

    </table>

</div>


@endsection
