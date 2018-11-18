@extends('layouts\master')
@section('content')

<div class="container">

  <div class="row">

      <div class="col">

        <p>This stocktake was performed on {{ $stocktakeDate }}</p>

      </div>

    </div>

    <div class="row">

      <div class="col">

        <table class="table">
            <tr>
                <th>Product Name</th>
                <th>Stock Available</th>
                <th>Max Available</th>
                <th>Order Count</th>
            </tr>

            @foreach ($stocktakeDetails as $stocktakeDetail)

            <tr>
              <td> {{$stocktakeDetail->product->product_name}} </td>
              <td> {{$stocktakeDetail->current_stock}} </td>
              <td> {{$stocktakeDetail->target_stock}} </td>
              <td> {{$stocktakeDetail->restock_count}} </td>
            </tr>

            @endforeach

        </table>

      </div>

    </div>


    <div class="row">

      <div class="col">

        <table class="table">
            <tr>
                <th>Product Name</th>
                <th>Stock Available</th>
                <th>Max Available</th>
                <th>Order Count</th>
            </tr>

            @foreach ($orderDetails as $orderDetail)

            <tr>
              <td> {{$orderDetail->product->product_name}} </td>
              <td> {{$orderDetail->current_stock}} </td>
              <td> {{$orderDetail->target_stock}} </td>
              <td> {{$orderDetail->restock_count}} </td>
            </tr>

            @endforeach

        </table>

      </div>

    </div>

</div>
