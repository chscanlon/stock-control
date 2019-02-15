@extends('layouts.master')
@section('content')

<div class="container">

    <h1 class="title">Create Stocktake</h1>

    <p>Stocktakes are created by uploading a Stock Level report generated from Timely. First run the Stock Level report in Timely and save it in a CSV format. Then use the form below to select the CSV file you saved and upload it into this application.</p>

    <form action="/stocktakes" method="POST"  enctype="multipart/form-data">
        @csrf

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
