@extends('layouts.master')
@section('content')

<div class="mx-4">

    <h1 class="title">Order History</h1>

    <form action="/poh" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-row align-items-center">
            <div class="col-auto my-1">
                <label class="mr-sm-2" for="selectedRange">Filter Report</label>
            </div>
            <div class="col-auto my-1">
                <select class="custom-select mr-sm-2" name="selectedRange" id="selectedRange">
                    <option selected>Choose Product Range...</option>
                    @foreach ($productRanges as $productRange)
                    <option value="{{ $productRange }}">{{ $productRange }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-auto my-1">
                <button type="submit" class="btn btn-primary">Apply</button>
            </div>
        </div>




    </form>



    <table class="table table-sm">
        <thead>
            <tr>
                @foreach ($keys as $key)

                <th> {{ $key }} </th>

                @endforeach
            </tr>
        </thead>

        <tbody>
            @foreach ($productOrders as $productOrder)
            <tr>
                @foreach ($keys as $key)

                <td> {{ $productOrder[$key] }} </td>

                @endforeach
            </tr>

            @endforeach

        </tbody>
    </table>


</div>


@endsection