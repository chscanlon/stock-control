<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Chris Scanlon">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Stock Control System</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    {{-- For Datatables --}}
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css">

    @stack('styles')
</head>

<body>
    <div id="app">
        <div>

            {{-- @include('partials.header') --}}
            @include('partials.navbar')


            <main style="padding-top: 5Rem">
                @yield('content')
            </main>

            <script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
            <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
            {{-- For Datatables --}}
            <script type="text/javascript" src="//cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>

            @stack('scripts')

        </div>
    </div>

</body>

</html>
