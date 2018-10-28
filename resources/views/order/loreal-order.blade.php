@extends('layouts.master')

@section('content')

<div class="container">

    <div class="row">
        <div class="col">
            <h3>New L'Oreal Order</h3>
            <p>The order has been calculated based on the current settings for Maximum and Available Stock. Review the order items and amounts before finalising the order.</p>
        </div>
    </div>

    <div class="row my-4">
        <div class="col">
            <a class="btn btn-primary" href="/confirm-order" role="button">Finalise Order</a>
        </div>
    </div>

    <div class="row">
        <div class="col">

            <table class="table table-sm">
                <tr>
                    <th>Supplier</th>
                    <th>Range</th>
                    <th>Name</th>
                    <th>Order Amount</th>
                    <th>Max Stock</th>
                    <th>Stock Available</th>
                </tr>

                @foreach ($lorealOrders as $lorealOrder)

                <tr>
                    <td> {{$lorealOrder->supplier}} </td>
                    <td> {{$lorealOrder->product_range}} </td>
                    <td> {{$lorealOrder->display_name}} </td>
                    <td> {{$lorealOrder->ORDER_AMOUNT}} </td>
                    <td> {{$lorealOrder->current_max_stock}} </td>
                    <td> {{$lorealOrder->current_stock_available}} </td>
                </tr>

                @endforeach

            </table>


        </div>
    </div>


</div>

@endsection
