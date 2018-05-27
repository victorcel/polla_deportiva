@extends('layouts.app')

@section('content')
    <div class="container text-center" style="">
        <div>
            <p><a href="" class="btn btn-default"> Atras</a></p>
        </div>

        <div id="products">
{{--@foreach($equipo as $equipos)--}}
            <div class="product white-panel" style="height: 696px !important;">
                <h3>{{ $equipos->pais }}</h3>
                <img src="{{ Storage::url("br.png")}}" class="img-responsive img-shirt">
                <h3>Colombia</h3>
                <img src="{{ Storage::url("co.png")}}" class="img-responsive img-shirt">
                <br>
            </div>
        </div>
    </div>

@endsection