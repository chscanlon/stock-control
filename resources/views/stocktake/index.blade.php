@extends('layouts.master')
@section('content')

<div class="container">

  <h1 class="title">Stocktakes</h1>

  <div class="row my-2">
      <div class="col">
          <a class="btn btn-primary" href="/stocktakes/create" role="button">New Stocktake</a>
      </div>
  </div>

  <table class="table table-sm">
      <tr>
          <th>Stocktake Id</th>
          <th>Stocktake Date</th>
          <th>Import Filename</th>
          <th>Item Count</th>
          <th></th>
      </tr>

      @foreach ($stocktakes as $stocktake)
      <tr>
          <td> <a href="/stocktakes/{{$stocktake->id}}"> {{$stocktake->id}} </a> </td>
          <td> {{$stocktake->stocktake_date}} </td>
          <td> {{$stocktake->stock_level_import_filename}} </td>
          <td> {{$stocktake->product_count}} </td>
          <td>
              <a class="btn btn-info" href="/stocktakes/{{$stocktake->id}}" role="button">Show</a>
          </td>
      </tr>
      @endforeach
  </table>

</div>

@endsection
