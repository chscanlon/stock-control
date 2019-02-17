@extends('layouts.master')
@section('content')


<div class="container">

    <h1 class="title">Order Detail</h1>

    <table class="table table-sm">
        <tr>
            <th>Supplier</th>
            <td> {{$order->supplier}} </td>
        </tr>
        <tr>
            <th>Order Date</th>
            <td> {{$order->order_date}} </td>
        </tr>
        <tr>
            <th>Status</th>
            <td> {{$order->status}} </td>
        </tr>
        <tr>
            <th>Item Count</th>
            <td> {{$order->item_count}} </td>
        </tr>

    </table>

    <table class="table table-sm">
        <tr>
            <th>Display Name</th>
            <th>Ordered Amount</th>
            <th>Received Amount</th>
        </tr>

        @foreach ($order->orderItems as $orderItem)

        <tr>
          <td> {{$orderItem->display_name}} </td>
          <td> {{$orderItem->order_amount}} </td>
          <td> {{$orderItem->delivered_amount}} </td>
        </tr>

        @endforeach

    </table>

</div>


@endsection
