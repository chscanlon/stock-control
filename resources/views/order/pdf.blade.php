{{-- @extends('layouts.master') --}}
{{-- @section('content')


<div class="container"> --}}

    <h1>Order Detail</h1>

    <table>
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

    <table>
        <tr>
            <th>Supplier</th>
            <th>Display Name</th>
            <th>Order Amount</th>
            <th>Max Stock</th>
            <th>Available Stock</th>
        </tr>

        @foreach ($order->orderItems as $orderItem)

        <tr>
            <td> {{$orderItem->supplier}} </td>
            <td> {{$orderItem->display_name}} </td>
            <td> {{$orderItem->order_amount}} </td>
            <td> {{$orderItem->max_stock}} </td>
            <td> {{$orderItem->available_stock}} </td>
        </tr>

        @endforeach

    </table>

{{-- </div> --}}

{{--
@endsection --}}
