@extends('layouts.master')
@section('content')


<div class="container">

    <h1 class="title">Stocktake Summary</h1>

    <table class="table table-sm">
        <tr>
            <th>Stocktake Id</th>
            <td> {{$stocktake->id}} </td>
        </tr>
        <tr>
            <th>Stocktake Date</th>
            <td> {{$stocktake->stocktake_date}} </td>
        </tr>
        <tr>
            <th>Product Count</th>
            <td> {{$stocktake->product_count}} </td>
        </tr>

    </table>

    <h2 class="title">Products Added</h2>

    <p>Number of new products added in this stocktake = {{$newProducts->count()}}</p>

    @if($newProducts->count() > 0)

        <table class="table table-sm">
            <tr>
                <th>Display Name</th>
                <th>Barcode</th>
            </tr>

            @foreach($newProducts as $newProduct)
            <tr>
                <td>{{$newProduct->display_name}}</td>
                <td>{{$newProduct->barcode}}</td>
            </tr>
            @endforeach
        </table>

    @endif


    <h2 class="title">Products Deleted</h2>

    <p>Number of products deleted in this stocktake = {{$deletedProducts->count()}}</p>

    @if($deletedProducts->count() > 0)

        <table class="table table-sm">
            <tr>
                <th>Display Name</th>
                <th>Barcode</th>
            </tr>

            @foreach($deletedProducts as $deletedProduct)
            <tr>
                <td>{{$deletedProduct->display_name}}</td>
                <td>{{$deletedProduct->barcode}}</td>
            </tr>
            @endforeach
        </table>

    @endif


@endsection
