@extends('layout.master')
@section('title','404')
@section('content')
    <div class="container">
        <div class="jumbotron text-center">

                <h1>404</h1>
                <h2>Aradığınız Sayfa Bulunamadı :(</h2>
            <br>
            <a href="{{route('anasayfa')}}" class="btn btn-primary">Anasayfa'ya Dön</a>
        </div>
    </div>
@endsection
