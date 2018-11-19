@extends('layouts.master')
@section('content')


<div class="container">

    <div class="row my-2">
        <div class="col">
            <h3>Order Management</h3>
        </div>
    </div>

    <div class="row my-2">
        <div class="col">
            <a class="btn btn-primary" href="/create-order" role="button">Create New L'Oreal Order</a>
        </div>
    </div>

    <div class="row my-2">
        <div class="col">
            <a class="btn btn-primary" href="/check-order" role="button">Check In Order</a>
        </div>
    </div>

    <div class="row">
        <div class="col">

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
                    <td> <a class="btn btn-primary" href="/order/{{$order->id}}" role="button">View</a> </td>
                </tr>

                @endforeach

            </table>


        </div>
    </div>



</div>


@endsection
