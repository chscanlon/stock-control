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

</div>


@endsection
