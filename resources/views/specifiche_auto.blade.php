@extends('layout')

@section('head')
    <title>specifiche_auto</title>
    @parent
    <link rel="stylesheet" href="{{ url('css/specifiche_auto.css') }}" />
    <script src="{{ url('js/specifiche_auto.js') }}" defer="true"></script>
    <script>const csrf_token = '{{ csrf_token() }}';</script>
@endsection

@section('nav')
    <div><a href="{{ url('home') }}">Home</a></div>
    @parent
@endsection

@section('content')
    <content>  
        @if($anno==null || $marca==null || $modello==null)
            <span>Nessun auto trovata!</span>
            exit;
        @endif
        <div id="auto"> 
            @if(!$img)
                <span>Immagine non disponibile</span>
            @else
                <img src="{{ $img }}"></img>
            @endif
            <h2 id="marca">Marca: <em>{{ $marca }}</em></h2>
            <h2 id="modello">Modello: <em>{{ $modello }}</em></h2>
            <h2 id="anno">Anno: <em>{{ $anno }}</em></h2>
            <button id="salva">
                @if(!$saved)
                    <img src='{{ url("images/save.png") }}'></img>
                @else
                    <img src='{{ url("images/saved.png") }}'></img>
                @endif
            </button>
        </div>
        <div id="scheda">
            <h1>SPECIFICHE:</h1>
            <div id="dati">
                @if($obj->Count ==0)
                    <span>Nessun dato disponibile</span>
                @else
                    @for($i=3; $i<$length; $i++)
                        @if($obj->Results[0]->Specs[$i]->Name=="CW")
                            <p>{{ $obj->Results[0]->Specs[$i]->Name }} = {{ $obj->Results[0]->Specs[$i]->Value }} Kg</p>
                        @elseif($obj->Results[0]->Specs[$i]->Name=="WD"){
                            <p>{{ $obj->Results[0]->Specs[$i]->Name }} = {{ $obj->Results[0]->Specs[$i]->Value }} %</p>
                        @else
                            <p>{{ $obj->Results[0]->Specs[$i]->Name }} = {{ $obj->Results[0]->Specs[$i]->Value }} cm</p>
                        @endif
                    @endfor
                @endif
            </div>
            <div id="legenda">
                <h1>LEGENDA:</h1>
                <img src="{{ url('/images/specifiche.jpg') }}"></img>
                <p>A->Distanza longitudinale tra il centro del paraurti anteriore e il centro della base del parabrezza</p>
                <p>B->-Autovettura: Distanza longitudinale tra il centro del paraurti posteriore e il centro la base delle luci posteriori<br>
                    &nbsp&nbsp&nbsp&nbsp-Station Wagon e van: Distanza longitudinale tra la modanatura superiore della retroilluminazione e il montante del chiavistello 
                    della porta anteriore<br>&nbsp&nbsp&nbsp&nbsp-Pick-up: Distanza longitudinale tra la proiezione più arretrata e il montante del 
                    chiavistello della porta anteriore
                </p>
                <p>C->L'altezza verticale massima del vetro laterale</p>
                <p>D->Distanza verticale tra la base del vetro laterale e il bordo inferiore del pannello a bilanciere</p>
                <p>E->Distanza tra le guide laterali o larghezza massima della parte superiore</p>
                <p>F->Sbalzo anteriore</p>
                <p>G->Sbalzo posteriore</p>
                <p>OLO->Lunghezza</p>
                <p>OW->Larghezza</p>
                <p>OH->Altezza totale</p>
                <p>WB->Passo</p>
                <p>TWF->Carreggiata anteriore</p>
                <p>WW1->Carreggiata posteriore</p>
                <p>CW->Peso a vuoto</p>
                <p>WD->Distribuzione del peso (anteriore/posteriore)</p>
            </div>
        </div>
    </content>
@endsection