@extends('layout.master')
@section('title','Sipariş Detay ')
@section('content')

    <div class="container">

        <div class="bg-content">
            <a href="{{route('siparisler')}}" class="btn btn-xs btn-primary">
                <i class="glyphicon glyphicon-arrow-left"></i>Siparişlere Dön
            </a>
            <div></div>
            <h2>Sipariş (SP-{{$siparis->id}})</h2>
            <table class="table table-bordererd table-hover">
                <tr>
                    <th colspan="1">Ürün</th>
                    <th>Tutar</th>
                    <th>Adet</th>
                    <th>Ara Toplam</th>
                    <th>Durum</th>
                </tr>
                <tr>
                    @foreach($siparis->sepet->sepet_urunler as $sepet_urun)

                    <td style="width: 120px">
                        <a href="{{route('urun',$sepet_urun->urun->slug)}}"><img src="http://lorempixel.com/120/100/food/2"></a>
                    </td>

                    <td>
                        <a href="{{route('urun',$sepet_urun->urun->slug)}}">{{$sepet_urun->urun->urun_adi}}</a>
                    </td>
                    <td>{{$sepet_urun->fiyati}}</td>
                    <td>{{$sepet_urun->adet}}</td>
                    <td>{{$sepet_urun->fiyati*$sepet_urun->adet}}</td>
                    <td>
                        {{$sepet_urun->durum}}
                    </td>
                </tr>
                @endforeach
                <tr>
                    <th colspan="4" class="text-right">Toplam Tutar</th>
                    <th colspan="2">{{$siparis->siparis_tutari}} ₺</th>
                    <th></th>
                </tr>

                <tr>
                    <th colspan="4" class="text-right">Toplam Tutar(KDV'li)</th>
                    <th colspan="2">{{$siparis->siparis_tutari}} ₺</th>
                    <th></th>
                </tr>
                <tr>
                    <th colspan="4" class="text-right">Siparis Durumu</th>
                    <th colspan="2">{{$siparis->durum}} ₺</th>
                    <th></th>
                </tr>

            </table>
        </div>
    </div>
@endsection
