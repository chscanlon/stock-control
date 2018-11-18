@extends('layouts\master')
@section('content')

<div class="container">

    @if ($stocktakes)

      <table>
          <tr>
              <th>Stocktake Date</th>
              <th>Action</th>
          </tr>

          @foreach ($stocktakes as $stocktake)

          <tr>
            <td> {{$stocktake->stocktake_date}} </td>
            <td>Link</td>
          </tr>

          @endforeach

      </table>

    @endif

</div>
