@extends('yonetim.layouts.master')
@section('title','Siparis Yönetimi')
@section('content')
    <h1 class="page-header">Siparis Yönetimi</h1>

    <form method="post"
          action="{{@$entry->id > 0 ? route('yonetim.siparis.kaydet',@$entry->id):route('yonetim.siparis.kaydet',0)}}">
        @csrf
        @method('POST')
        <div class="pull-right">
            <button type="submit" class="btn btn-primary">{{@$entry->id > 0 ? "Güncelle":"Kaydet"}}</button>
        </div>
        <h3 class="sub-header">Siparis{{@$entry->id>0? "Düzenle":"Ekle"}}</h3>

        @include('layout.partials.errors')
        @include('layout.partials.alert')

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="adsoyad">Ad Soyad</label>
                    <input type="text" class="form-control" id="adsoyad" name="adsoyad"
                           value="{{old('adsoyad',$entry->adsoyad)}}" placeholder="Ad Soyad">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="adres">Adres</label>

                    <input type="text" class="form-control" id="adres" name="adres" value="{{old('adres',$entry->adres)}}"
                           placeholder="Adres">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="telefon"> Telefon</label>
                    <input type="text" class="form-control" id="telefon" name="telefon"
                              value="{{old('telefon',$entry->telefon)}}" placeholder="Telefon"></input>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="ceptelefon"> Telefon</label>
                    <input type="text" class="form-control" id="ceptelefon" name="ceptelefon"
                              value="{{old('ceptelefon',$entry->ceptelefon)}}" placeholder="Cep Telefonu"></textarea>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="durum"> Durum</label>
                    <select name="durum" class="form-control"id="durum">
                        <option {{old('durum',$entry->durum)=='Siparişiniz Alındı'? 'selected':''}}>Siparişiniz Alındı</option>
                        <option {{old('durum',$entry->durum)=='Ödeme Onaylandı'? 'selected':''}}>Ödeme Onaylandı</option>
                        <option {{old('durum',$entry->durum)=='Kargoya Verildi'? 'selected':''}}>Kargoya Verildi</option>
                        <option {{old('durum',$entry->durum)=='Sipariş Tamamlandı'? 'selected':''}}>Sipariş Tamamlandı</option>
                    </select>
                </div>
            </div>
        </div>


    </form>
    <h2>Sipariş (SP-{{$entry->id}})</h2>
    <table class="table table-bordererd table-hover">
        <tr>
            <th colspan="1">Ürün</th>
            <th>Tutar</th>
            <th>Adet</th>
            <th>Ara Toplam</th>
            <th>Durum</th>
        </tr>
        <tr>
            @foreach($entry->sepet->sepet_urunler as $sepet_urun)

                <td style="width: 120px">
                    <a href="{{route('urun',$sepet_urun->urun->slug)}}"> <img src="{{$sepet_urun->urun->detay->urun_resim!=null? asset('uploads/urunler/'.$sepet_urun->urun->detay->urun_resim):
                            'http://lorempixel.com/120/100/food/1'}}" class="img-responsive" style="width:120px; height:100px"></a>
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
            <th colspan="2">{{$entry->siparis_tutari}} ₺</th>
            <th></th>
        </tr>

        <tr>
            <th colspan="4" class="text-right">Toplam Tutar(KDV'li)</th>
            <th colspan="2">{{$entry->siparis_tutari}} ₺</th>
            <th></th>
        </tr>
        <tr>
            <th colspan="4" class="text-right">Siparis Durumu</th>
            <th colspan="2">{{$entry->durum}} ₺</th>
            <th></th>
        </tr>

    </table>
@endsection
