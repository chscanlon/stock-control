@extends('layouts.master')
@section('content')


<div class="container">

    <div class="row">

        <div class="col">

            <form action="/file-upload" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }} Type of stocktake:
                <br />
                <input type="text" name="contents" />
                <br /><br /> Content Type:
                <br />
                <input type="file" name="stock" />
                <br /><br />
                <input type="submit" value=" Save " />
            </form>

        </div>

    </div>

</div>


@endsection
