@extends('layouts.master')
@section('content')

<div class="container">

    <div class="row my-2">
        <div class="col">
            <h3>Stocktake Management</h3>
        </div>
    </div>


    <div class="row my-2">
        <div class="col">
            <h4>Upload a Timely Stock Levels Report</h4>
        </div>
    </div>

    <form action="/stocktake" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="row my-2">
            <div class="col">

                <div class="form-group">
                    <label for="stockLevelReport">Select a file to upload</label>
                    <input type="file" class="form-control" id="stockLevelReport" name="stockLevelReport" placeholder="Select File">
                </div>

            </div>
        </div>

        <div class="row my-2">
            <div class="col">

                <button type="submit" class="btn btn-primary">Submit</button>

            </div>
        </div>

    </form>

</div>

@endsection
