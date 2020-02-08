@extends('layouts.master')
@section('content')

<div class="container">

    <h1 class="title">Products in Timely</h1>

    @include('product.ajax-products')

</div>


@endsection
