@extends('layout.master')
@section('title','Sonuçlar')
@section('content')


    <div class="container">
        <ol class="breadcrumb">
            <li>
                <a href="{{route('anasayfa')}}">Anasayfa</a>
             </li>

            <li class="active">Arama Sonuçları</li>
        </ol>

        <div class="products bg-content">
            <div class="row">
                @if(count($urunler)==0)
                    <div class="col md-12 text-center">
                        <h2>Aradığınız ürün bulunamadı :(</h2>
                    </div>
                    @endif
                @foreach($urunler as $urun)
                    <a href="{{route('urun',$urun->slug)}}">
                        <img src="http://lorempixel.com/100/185/food/1" class="img-responsive" alt="{{$urun->urun_adi}}">
                    </a>
                        <p>
                            <a href="{{route('urun',$urun->slug)}}">
                                {{$urun->urun_adi}}
                            </a>

                        </p>
                        <p>
                    <p class="price">{{ $urun->fiyati }} ₺</p>
                        </p>


                    @endforeach
            </div>
            {{$urunler->appends(['aranan'=>old('aranan')])->links()}}<!--Links fonksiyonu sayfalandırmalarla ilgili  bağlantıları otomatik olarak getirmeyi sağlıyor-->
        </div>
    </div>
@endsection
