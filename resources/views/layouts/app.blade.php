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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css"
          href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
</head>
<body style="background-image: url('{{ asset('storage/ruleta.jpg')}}');background-color: #aecc2b;background-position: center center; background-repeat: no-repeat;background-attachment: fixed; background-size: cover">
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}

                </a>

            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                    @else
                        @if(Session::has('puntos'))
{{--                        @foreach(Session::get('ticket') as $test)--}}
                            <h1 class="col-md-pull-9">Puntos {{ Session::get('puntos')['puntos'] }}</h1>
                        {{--@endforeach--}}
                        {{--<div class="alert alert-danger">--}}

                        {{--</div>--}}
                        @endif
                        {{--<h3 class="col-md-pull-9">Puntos {{ }}</h3>--}}
                        <li><a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Salir
                            </a></li>

                        <a> <i style="font-size:30px"> <span
                                        class="badge"> {{ Auth::user()->name }}</span></i></a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                              style="display: none;">
                            {{ csrf_field() }}
                        </form>

                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/pinterest_grid.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-number-input.js') }}"></script>
@yield('js')
</body>
</html>
