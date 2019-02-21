@extends('layouts.master')
@section('content')


<div class="container">

    <h1 class="title">Order Delivery</h1>
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

    @if ($itemsDeliveredNotOrdered->count() > 0)

    <h3 class="title">Items delivered but not ordered</h3>
    <table class="table table-sm">
        <tr>
            <th>Display Name</th>
            <th>Received Amount</th>
        </tr>

        @foreach ($itemsDeliveredNotOrdered as $key => $value)
        <tr>
            <td> {{$key}} </td>
            <td> {{$value}} </td>
        </tr>
        @endforeach

    </table>

    @endif

    <h3 class="title">Items missing from order</h3>
    <table class="table table-sm">
        <tr>
            <th>Display Name</th>
            <th>Ordered Amount</th>
            <th>Received Amount</th>
        </tr>

        @foreach ($order->orderItems as $orderItem)

        @if ($orderItem->order_amount > $orderItem->delivered_amount)
        <tr>
            <td> {{$orderItem->display_name}} </td>
            <td> {{$orderItem->order_amount}} </td>
            <td> {{$orderItem->delivered_amount}} </td>
        </tr>
        @endif

        @endforeach

    </table>

    <h3 class="title">Items correctly delivered</h3>
    <table class="table table-sm">
        <tr>
            <th>Display Name</th>
            <th>Ordered Amount</th>
            <th>Received Amount</th>
        </tr>

        @foreach ($order->orderItems as $orderItem)

        @if ($orderItem->order_amount == $orderItem->delivered_amount)
        <tr>
            <td> {{$orderItem->display_name}} </td>
            <td> {{$orderItem->order_amount}} </td>
            <td> {{$orderItem->delivered_amount}} </td>
        </tr>
        @endif

        @endforeach

    </table>

</div>


@endsection
