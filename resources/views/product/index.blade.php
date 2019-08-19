@extends('layouts.master')
@section('content')

<div class="container">

    <h1 class="title">L'Oreal Products</h1>

    @include('product.ajax-products')

</div>


@endsection
