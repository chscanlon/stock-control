@extends('layouts.master')
@section('content')


<div class="container">

    <h1 class="title">Orders</h1>

    <div class="row my-2">
        <div class="col">
            <a class="btn btn-primary" href="/orders/create" role="button">New Order</a>
        </div>
        {{-- <div class="col">
            <a class="btn btn-primary" href="/check-order" role="button">Check Order</a>
        </div> --}}
    </div>

    <table class="table table-sm">
        <tr>
            <th>Order Id</th>
            <th>Supplier</th>
            <th>Order Date</th>
            <th>Status</th>
            <th>Item Count</th>
            <th></th>
            <th></th>
        </tr>

        @foreach ($orders as $order)
        <tr>
            <td> <a href="/orders/{{$order->id}}"> {{$order->id}} </a> </td>
            <td> {{$order->supplier}} </td>
            <td> {{$order->order_date}} </td>
            <td> {{$order->status}} </td>
            <td> {{$order->item_count}} </td>
            <td>
                <a class="btn btn-info" href="/orders/{{$order->id}}" role="button">Show</a>
            </td>
            @if (($order->status) === 'Confirmed')
              <td>
                  <a class="btn btn-info" href="/order-check-in-delivery/{{$order->id}}" role="button">Check In</a>
              </td>
              <td>
                  <a class="btn btn-info" href="/order-export-pdf/{{$order->id}}" role="button">Print PDF</a>
              </td>
            @endif
            @if (($order->status) === 'Draft')
            <td>
                <form action="/orders/{{$order->id}}" method="post">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-secondary">Delete</button>
                </form>
            </td>
            @endif
        </tr>
        @endforeach
    </table>

</div>

@endsection
