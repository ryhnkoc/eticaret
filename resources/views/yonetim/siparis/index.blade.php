@extends('yonetim.layouts.master')
@section('title','Siparis Yönetimi')
@section('content')
    <h1 class="page-header">Siparis Yönetimi</h1>

    <h1 class="sub-header"> Siparia Listesi </h1>
    <div class="well">

        <form method="post" action="{{route('yonetim.siparis')}}" class="form-inline">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="search">Siparis Arama</label>
                <input type="text" class="form-control form-control-sm" name="aranan" id="aranan" placeholder="Ara"
                       value="{{old('aranan')}}">
            </div>
            <button type="submit" class="btn btn-primary">Ara</button>
            <a href="{{route('yonetim.siparis')}}" class="btn btn-primary">Temizle</a>
        </form>
    </div>
    @include('layout.partials.alert')
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="thead-dark">
            <tr>

                <th>Kullanıcı</th>
                <th>Siparis Kodu</th>
                <th>Tutar</th>
                <th>Durum</th>
                <th>Siparis Tarihi</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @if(count($list)==0)
                <tr>
                    <td colspan="7">Kayıt Bulunamadı</td>
                </tr>
            @endif

            @foreach($list as $entry)
                <tr>

                    <td>{{$entry->sepet->kullanici->adsoyad}}</td>
                    <td>SP-{{$entry->id}}</td>
                    <td>{{$entry->siparis_tutari*((100+config('cart.tax'))/100)}}</td>
                    <td>{{$entry->durum}}</td>
                    <td>{{$entry->created_at}}</td>


                    <td style="width: 100px">
                        <a href="{{route('yonetim.siparis.duzenle',$entry->id)}}" class="btn btn-xs btn-success"
                           data-toggle="tooltip" data-placement="top"
                           title="Düzenle">
                            <span class="fa fa-pencil"></span>
                        </a>
                        <a href="{{route('yonetim.siparis.sil',$entry->id)}}" class="btn btn-xs btn-danger"
                           data-toggle="tooltip" data-placement="top"
                           title="Sil" onclick="return confirm('Emin misiniz?')">
                            <span class="fa fa-trash"></span>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$list->links()}}
    </div>
@endsection
