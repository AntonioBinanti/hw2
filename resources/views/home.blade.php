@extends('layout')

@section('head')
    @parent
    <title>home</title>
    <link rel="stylesheet" href="{{ url('css/home.css') }}" />
    <script src="{{ url('js/home.js') }}" defer="true"></script>    
@endsection

@section('content')
    <header>
        <h1>Trova le specifiche della tua auto</h1>
        
        <div id="overlay"></div>
    </header>
    <content id="galleria">
        <h2>scegli un modello:</h2>
        <div id="loghi">
            
        </div>
    </content>
    <content id="modal_view" class="hidden">
    </content>
@endsection