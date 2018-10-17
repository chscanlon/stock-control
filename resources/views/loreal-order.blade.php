@extends('layouts.master')

@section('content')

<div class="container">

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

@endsection
