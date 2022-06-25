<html>
    <head>
    <title>register</title>
    <link rel="stylesheet" href="{{ url('css/register.css') }}" />
    <script src="{{ url('js/register.js') }}" defer="true"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Koulen&family=Libre+Baskerville&family=Lobster&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <section class="sfondo">
        <div class="overlay"></div>
            <div class="form">
                <h1>Inserisci i tuoi dati</h1>
                @if($error == 'username_già_utilizzato')
                <section class='error'>Username già utilizzato</section>
                @elseif($error == 'password_corta')
                <section class='error'>La password deve superare 8 caratteri</section>
                @elseif($error == 'password_non_coincidenti')
                <section class='error'>Le password non coincidono</section>
                @elseif($error == 'email_già_utilizzata')
                <section class='error'>Email già utilizzata</section>
                <form name='signup' method='post'>
                @elseif($error == 'campi_vuoti')
                <section class='error'>Riempi tutti i campi</section>
                @endif
                <form name='signup' method='post'>
                @csrf
                <div class="name">
                    <div><label for='name'>Nome</label></div>
                    <div><input type='text' name='name' id='name' value='{{ old("name") }}'></div>
                    <span>Inserisci Nome</span>
                </div>
                <div class="surname">
                    <div><label for='surname'>Cognome</label></div>
                    <div><input type='text' name='surname' id='surname' value='{{ old("surname") }}'></div>
                    <span>Inserisci Cognome</span>
                </div>
                <div class="username">
                    <div><label for='username'>Nome utente</label></div>
                    <div><input type='text' name='username' id='username' value='{{ old("username") }}'></div>
                    <span>Inserisci Nome Utente</span>
                </div>
                <div class="email">
                    <div><label for='email'>E-mail</label></div>
                    <div><input type='text' name='email' id='email' value='{{ old("email") }}'></div>
                    <span>Inserisci E-mail</span>
                </div>
                <div class="password">
                    <div><label for='password'>Password</label></div>
                    <div><input type='password' name='password' id='password' value='{{ old("password") }}'></div>
                    <span>Inserisci almeno 8 caratteri</span>
                </div>
                <div class="confirm_password">
                    <div><label for='confirm_password'>Conferma password</label></div>
                    <div><input type='password' name='confirm_password' id='confirm_password' value='{{ old("confirm_password") }}'></div>
                    <span>Password non coincidenti</span>
                </div>
                <div class="allow"> 
                    <div><input type='checkbox' name='allow' value="1"></div>
                    <div><label for='allow'>Acconsento al furto dei dati personali</label></div>
                    <span>Campo obbligatorio</span>
                </div>
                <div class="submit">
                    <input type='submit' value="Registrati">
                </div>
            </form>
            <div class="signup"><h2>Hai già un account? <a href="{{ url('login') }}">Accedi</a></h2>
            </div>
        </section>
    </body>
</html>