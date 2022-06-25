<html>
<head>
    @section('head')
    <script>
        const BASE_URL= "{{ url('/') }}/";
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Koulen&family=Libre+Baskerville&family=Lobster&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @show
</head>
<body>
    <nav>
        @section('nav')
        <div id="saved_cars">
            <a href="{{ url('auto_salvate') }}">AUTO SALVATE</a>
            <span>{{ $user['n_car_saved'] }}</span>
        </div>
        <div><a href="{{ url('logout') }}">LOGOUT</a></div>
        <div id="profilo">
            <a>{{ $user['username'] }}</a>
        </div>
        @show
    </nav>
    @yield('content')
    <footer>
        <h2>Powered by Antonio Binanti 1000002208</h2>
    </footer>
</body>
</html>