@extends('yonetim.layouts.master')
@section('title','Kullanici Yönetimi')
@section('content')
    <h1 class="page-header">Kullanici Yönetimi</h1>

    <form method="post" action="{{route('yonetim.kullanici.kaydet',@$entry->id)}}">
        @csrf
        @method('POST')
        <div class="pull-right">
            <button type="submit" class="btn btn-primary">{{@$entry->id > 0 ? "Güncelle":"Kaydet"}}</button>
        </div>
        <h3 class="sub-header">Kullanıcı{{@$entry->id>0? "Düzenle":"Ekle"}}</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="adsoyad">Ad Soyad</label>
                    <input type="text" class="form-control" id="adsoyad" value="{{$entry->adsoyad}}" placeholder="Ad Soyad">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" value="{{$entry->email}}" placeholder="Email">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="sifre">Şifre</label>
                    <input type="password" class="form-control" id="sifre"  placeholder="Şifre">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="adres">Adres</label>
                    <input type="text" class="form-control" id="adres" value="{{$entry->detay->adres}}" placeholder="Adres">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="telefon">Telefon</label>
                    <input type="text" class="form-control" id="telefon" value="{{$entry->detay->telefon}}" placeholder="Telefon">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="ceptelefonu">Cep Telefonu</label>
                    <input type="text" class="form-control" id="ceptelefonu" value="{{$entry->detay->cepTelefon}}" placeholder="Cep Telefonu">
                </div>
            </div>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="aktif_mi" value="true" {{$entry->aktif_mi ? 'checked' : ''}}>Aktif Mi
            </label>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="yonetici_mi" value="true" {{$entry->yonetici_mi ? 'checked' : ''}}>Yönetici Mi
            </label>
        </div>


    </form>
@endsection
