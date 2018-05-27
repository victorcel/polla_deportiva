@extends('layouts.app')

@section('content')
    <div class="container text-center " style="">

        <div>
            {{ $equipos->links() }}

        </div>
        {!! Form::open(['route' => 'anotar.store', 'method' => 'post'] ) !!}
        <div id="padre">

            @foreach($equipos as $equipo)
                <input type="hidden" name="partido_id" value="{{ $equipo->id }}"/>
                <div id="hijo">
                    <div class="product white-panel" style="height: 456px !important;">
                        <h3>{{$equipo->equipo_1}}</h3>
                        <img src="{{ asset($equipo->bandera_1 )}}" class="img-responsive img-shirt">
                        <br>
                        <div class="product-info">
                            <div>
                                <example message="1"></example>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="hijo">
                    <div class="product white-panel" style="height: 456px !important;">
                        <h3>{{$equipo->equipo_2}}</h3>
                        <img src="{{ asset($equipo->bandera_2 )}}" class="img-responsive img-shirt">
                        <br>
                        <div class="product-info">
                            <example message="2"></example>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        @for ($i = 1; $i < 24; $i++)
           <br>
        @endfor
        {!! Form::submit('ANOTAR', ['class' => 'btn btn-success btn-lg pull-center','style'=>'width:100px;height: 70px;text-align: center']) !!}
        {!! Form::close() !!}
    </div>

@endsection