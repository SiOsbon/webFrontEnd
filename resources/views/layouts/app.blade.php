<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body id="body">
    <div id="page">
        <header>
            <div class="container">
                <div class="row">
                    <div class="col-t-12">
                        <h1 class="logo"><a href="{{route('home')}}">Daratus</a></h1>
                        <a class="menu-button" href="#"></a>
                        <ul class="menu">
                            <li>
                                <a href="{{ route('statistics') }}">System status</a>
                            </li>
                            <li>
                                <a href="{{ route('nodes') }}">Node statistics</a>
                            </li>
                            <li>
                                <a href="{{ route('data_contracts') }}">Data contracts</a>
                            </li>
                            <li class="key-button">
                                <a href="{{ route('download') }}"><div class="telegram-icon"></div>Download Node</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <div id="content">
        @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/combined.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</body>
</html>
