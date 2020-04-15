@extends('layouts.app')
@section('content')

<div class="flex items-center">
    <div class="md:w-3/4 md:mx-auto">

        <div class="flex flex-col break-words bg-white border border-2 rounded shadow-md">

            <div class=" py-3 px-6 mb-0 text-3xl font-semibold bg-gray-200 text-gray-700">
                Order Detail
            </div>

            <div class="w-full p-6">
                <livewire:order-detail :order="$order">
            </div>

        </div>
    </div>
</div>




    {{-- <table class="table table-sm">
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

    </table> --}}

    {{-- <div class="row my-2">
        <div class="col">
          <form action="/order-confirm/{{$order->id}}" method="post">
              @csrf
              <button type="submit" class="btn btn-secondary">Confirm Order</button>
          </form>
        </div>
    </div> --}}



@endsection
