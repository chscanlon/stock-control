@extends('layouts.master')
@section('content')

<div class="container">

    <h1 class="title">New Products in Stock Level Report</h1>


    <table class="table table-sm">
        <tr>
            <th>Display Name</th>
            <th>Barcode</th>
            <th>Available Stock</th>
        </tr>

        @foreach ($newProducts as $newProduct)
        <tr>
            <td> {{$newProduct[0]}} </td>
            <td> {{$newProduct[1]}} </td>
            <td> {{$newProduct[2]}} </td>
        </tr>

        @endforeach

    </table>


</div>


@endsection
