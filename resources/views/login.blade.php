<html>
    <head>
        <title>login</title>
        <link rel="stylesheet" href="{{ url('css/login.css') }}" />
        <script src="{{ url('js/login.js') }}" defer="true"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Koulen&family=Libre+Baskerville&family=Lobster&display=swap" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <section class="sfondo">
            <div class="overlay"></div>
            <div class="form">
                <h1>Benvenuto!</h1>
                @if($error == 'errati')
                <section class='error'>Username e/o password errati.</section>
                @elseif($error == 'campi_vuoti')
                <section class='error'>Inserisci username e password.</section>
                @endif
                <form name='login' method='post'>
                @csrf
                <div class="username">
                    <div><label for='username'>Nome utente</label></div>
                    <div><input type='text' name='username' id='username' value="{{ old('username') }}"></div>
                    <span>Inserire Username</span>
                </div>
                <div class="password">
                    <div><label for='password'>Password</label></div>
                    <div><input type='password' name='password' id='password'></div>
                    <span>Inserire Password</span>
                </div>
                <div class="submit submit_login">
                    <input type='submit' value="Accedi">
                </div>
            </form>
            <div class="signup"><h2>Non hai un account? <a href="{{ url('register') }}">Iscriviti</a></h2>
            </div>
        </section>
    </body>
</html>