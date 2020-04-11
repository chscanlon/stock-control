@extends('layouts.app')
@section('content')

<div class="flex items-center">
    <div class="md:w-3/4 md:mx-auto">

        <div class="flex flex-col break-words bg-white border border-2 rounded shadow-md">

            <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
                Orders
            </div>

            <div class="">
                <a class="" href="/orders/create" role="button">New Order</a>
            </div>

            <table class="mx-auto table-auto border">
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
                    <td>
                        <form action="/orders/{{$order->id}}" method="post">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-secondary">Delete</button>
                        </form>
                    </td>
                    @if (($order->status) === 'Confirmed')
                      <td>
                          <a class="btn btn-info" href="/order-check-in-delivery/{{$order->id}}" role="button">Check In</a>
                      </td>
                      <td>
                          <a class="btn btn-info" href="/order-export-pdf/{{$order->id}}" role="button">Print PDF</a>
                      </td>
                    @endif
                </tr>
                @endforeach
            </table>

        </div>
    </div>
</div>

@endsection
