@extends('layouts.app')

@section('content')
    <div class="container text-center" style="">
        <div>
            <p><a href="" class="btn btn-default"> Atras</a></p>
        </div>

        <div id="products">

                <div class="product white-panel" style="height: 596px !important;">
                    <h3>Brazil</h3>
                    <img src="{{ Storage::url("br.png")}}" class="img-responsive img-shirt">
                    <br>
                    <div class="product-info">
                        <example message="0"></example>

                    </div>

                </div>
            <div class="product white-panel" style="height: 596px !important;">
                <h3>Colombia</h3>
                <img src="{{ Storage::url("co.png")}}" class="img-responsive img-shirt">
                <br>
                <div class="product-info">
                    <example message="1"></example>

                </div>

            </div>

        </div>
    </div>

@endsection