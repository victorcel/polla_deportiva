@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Login</div>
                    <div class="panel-body">
                        @include('layouts.info')
                        {!! Form::open(['route' => 'login', 'method' => 'post'] ) !!}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Tarjeta Sun Reawrds</label>

                            <div class="col-md-6">
                                <input id="email" type="text" v-model="lector" class="form-control" autocomplete="off"
                                       name="email" @keyup.enter="borrarTarjeta"
                                       value="{{old('email')}}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <label for="password" class="col-md-4 ">Cedula</label>

                            <div class="col-md-6">
                                <input id="password" type="password" v-model="getCedula" class="form-control"
                                       name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="panel panel-default">


                                    <div class="panel-body">
                                        @if (session('status'))
                                            <div class="alert alert-success ">
                                                {{ session('status') }}
                                            </div>
                                        @endif
                                        <div class="auth-form-body mt-3">

                                            <div class="form-group">

                                            </div>
                                            <div class="form-group">

                                            </div>
                                            <div class="row">
                                                <div class="col-md-2 col-md-offset-2">
                                                    @include('layouts.teclado')

                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::submit('OK', ['class' => 'btn btn-success btn-lg pull-left','style'=>'width:100px;height: 70px;text-align: center']) !!}
                        {!! Form::close() !!}
                        {{--{!! Form::submit('BORRAR ', ['class' => 'btn btn-danger btn-lg pull-right','@click="borrarTarjeta"']) !!}--}}
                        {!! Form::submit('BORRAR ', ['class' => 'btn btn-danger btn-lg pull-right','style'=>'width:100px;height: 70px;text-align: center','@click.prevent="borrarTarjeta"']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
