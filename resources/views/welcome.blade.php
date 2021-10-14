<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{env('app.name')}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('landing/css/style.css')}}">


</head>

<body>
    <!-- <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand">{{env('App_name')}}</a>
            <div class="d-flex">
                @if (Route::has('login'))
                @auth
                @if(auth()->user()->hasRole('admin'))
                <a href="{{ url('/admin') }}" class="btn btn-outline-secondary">Dashboard</a>
                @elseif(auth()->user()->hasRole('manager'))
                <a href="{{ url('/manager') }}" class="btn btn-outline-secondary">Dashboard</a>
                @endif
                @else
                <a href="{{ route('login') }}" class="btn btn-outline-secondary">Log in</a>
                @endauth
                @endif
            </div>
        </div>
    </nav> -->
    <!-- home container id starts -->
    <div id="home-container">
        <!-- inner sub id starts -->
        <div id="inner">
            <img src="{{asset('assets/brand_icon.png')}}" alt=" logo" id="logo">
            <h1>Meediaty</h1>
            <p class="subtitle">Société SBNH</p>

            @if (Route::has('login'))
            @auth
            @if(auth()->user()->hasRole('admin'))
            <a href="{{ url('/admin') }}" class="cta cta--white ">Dashboard</a>
            @elseif(auth()->user()->hasRole('manager'))
            <a href="{{ url('/manager') }}" class="cta cta--white ">Dashboard</a>
            @endif
            @else
            <a href="{{ route('login') }}" class="cta cta--white ">Log in</a>
            @endauth
            @endif
        </div>
        <!-- inner sub id ends -->

        <!-- illustration sub id starts -->
        <div id="illustration">
            <!-- <img src="{{asset('landing/assets/dash.svg')}}" alt="dash img" id="dash" class="crypto-icons"> -->
            <!-- <img src="{{asset('landing/assets/miota.svg')}}" alt="iota img" id="iota" class="crypto-icons"> -->
            <!-- <img src="{{asset('landing/assets/eth.svg')}}" alt="eth img" id="eth" class="crypto-icons"> -->
            <img src="{{asset('landing/assets/monitor.svg')}}" alt="monitor img" id="monitor">
        </div>
        <!-- illustration sub id ends -->
    </div>
    <!-- home container id ends -->

</body>

</html>