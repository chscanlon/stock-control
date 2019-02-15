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

    <div class="row">

        <div class="col">

            <form action="/check-order" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="form-group">
                  <label for="stockBeforeOrderUpdate">Stock level report before order update</label>
                  <input type="file" class="form-control-file" id="stockBeforeOrderUpdate" name="stockBeforeOrderUpdate">
                </div>

                <div class="form-group">
                  <label for="stockAfterOrderUpdate">Stock level report after order update</label>
                  <input type="file" class="form-control-file" id="stockAfterOrderUpdate" name="stockAfterOrderUpdate">
                </div>

                <button class="btn btn-primary" type="submit">Process Order</button>

            </form>

        </div>

    </div>

</div>


@endsection
