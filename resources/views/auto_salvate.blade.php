@extends('layout')

@section('head')
    <title>auto_salvate</title>
    @parent
    <link rel="stylesheet" href="{{ url('css/auto_salvate.css') }}" />
    <script src="{{ url('js/auto_salvate.js') }}" defer="true"></script>
@endsection

@section('nav')
    <div><a href="{{ url('home') }}">Home</a></div>
    @parent
@endsection

@section('content')
    <content>
        <div id="galleria">
        </div>
    </content>
@endsection