@extends('yonetim.layouts.master')
@section('title','Kullanici Yönetimi')
@section('content')
    <h1 class="page-header">Kullanici Yönetimi</h1>

    <form method="post" action="{{@$entry->id > 0 ? route('yonetim.kullanici.kaydet',@$entry->id):route('yonetim.kullanici.kaydet',0)}}">
        @csrf
        @method('POST')
        <div class="pull-right">
            <button type="submit" class="btn btn-primary">{{@$entry->id > 0 ? "Güncelle":"Kaydet"}}</button>
        </div>
        <h3 class="sub-header">Kullanıcı{{@$entry->id>0? "Düzenle":"Ekle"}}</h3>
        @include('layout.partials.errors')
        @include('layout.partials.alert')
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="adsoyad">Ad Soyad</label>
                    <input type="text" class="form-control" id="adsoyad" name="adsoyad" value="{{old('adsoyad',$entry->adsoyad)}}" placeholder="Ad Soyad">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{old('email',$entry->email)}}" placeholder="Email">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="sifre">Şifre</label>
                    <input type="password" class="form-control" name="sifre" id="sifre"  placeholder="Şifre">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="adres">Adres</label>
                    <input type="text" class="form-control" id="adres" name="adres" value="{{old('adres',$entry->detay->adres)}}" placeholder="Adres">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="telefon">Telefon</label>
                    <input type="text" class="form-control" id="telefon" name="telefon" value="{{old('telefon',$entry->detay->telefon)}}" placeholder="Telefon">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="ceptelefonu">Cep Telefonu</label>
                    <input type="text" class="form-control" id="ceptelefonu" name="cepTelefon" value="{{old('cepTelefon',$entry->detay->cepTelefon)}}" placeholder="Cep Telefonu">
                </div>
            </div>
        </div>
        <div class="checkbox">
            <label>
                <input type="hidden"name="aktif_mi" value="false">
                <input type="checkbox" name="aktif_mi" value="true" {{old('aktif_mi',$entry->aktif_mi) ? 'checked' : ''}}>Aktif Mi
            </label>
        </div>
        <div class="checkbox">
            <label>

                <input type="hidden"name="aktif_mi" value="false">
                <input type="checkbox" name="yonetici_mi" value="true" {{old('yonetici_mi',$entry->yonetici_mi)? 'checked' : ''}}>Yönetici Mi
            </label>
        </div>


    </form>
@endsection
