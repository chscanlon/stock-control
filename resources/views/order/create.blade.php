@extends('layouts.master')
@section('content')


<div class="container">

    <h1 class="title">Create Order</h1>

    <p>Currently, the system only supports creating orders for L'Oreal. To create a new order based on current stock levels, simply click the button below. A Stock Level report was imported from Timely on dd/mm/yyyy. You may want to import a new Stock Level report before creating the order.</p>

    <p>Orders are initially created with a status of Draft. You can review, edit and even delete the order before submitting it to the supplier.</p>

    <form class="" action="/orders" method="post">
      @csrf

      <div class="row my-2">
          <div class="col">
              <button type="submit" class="btn btn-primary">Create Order</button>
          </div>
      </div>

    </form>

</div>


@endsection
