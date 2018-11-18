@extends('layouts.master')
@section('content')

<div class="container">

      <table>
          <tr>
              <th>Supplier</th>
              <th>Range</th>
              <th>Count</th>
          </tr>

          @foreach ($productRangeCounts as $productRangeCount)

          <tr>
            <td> {{$productRangeCount->supplier}} </td>
            <td> {{$productRangeCount->product_range}} </td>
            <td> {{$productRangeCount->product_count}} </td>
          </tr>

          @endforeach

      </table>

      <table>
          <tr>
              <th>Supplier</th>
              <th>Range</th>
              <th>Count (No Barcode)</th>
          </tr>

          @foreach ($productNoBarcodeRangeCounts as $productNoBarcodeRangeCount)

          <tr>
            <td> {{$productNoBarcodeRangeCount->supplier}} </td>
            <td> {{$productNoBarcodeRangeCount->product_range}} </td>
            <td> {{$productNoBarcodeRangeCount->product_count}} </td>
          </tr>

          @endforeach

      </table>

</div>
