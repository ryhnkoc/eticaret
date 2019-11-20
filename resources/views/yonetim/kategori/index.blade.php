@extends('yonetim.layouts.master')
@section('title','Kategori Yönetimi')
@section('content')
    <h1 class="page-header">Kategori Yönetimi</h1>

    <h1 class="sub-header"> Kategori Listesi </h1>
    <div class="well">
        <div class="btn-group pull-right">
            <a href="{{route('yonetim.kategori.yeni')}}" class="btn btn-primary">Yeni Kayıt</a>
        </div>
        <form method="post" action="{{route('yonetim.kategori')}}" class="form-inline">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="search">Arama</label>
                <input type="text" class="form-control form-control-sm" name="aranan" id="aranan" placeholder="Ara"
                       value="{{old('aranan')}}">
                <label for="ust_id">Üst Kategoriler</label>
                <select name="ust_id" id="ust_id" class="form-control">
                    <option value="">Seçiniz</option>
                    @foreach($ana_kategoriler as $ana_kategori)
                        <option
                            value="{{$ana_kategori->id}}" {{old('ust_id')==$ana_kategori->id ? 'selected':''}}>{{$ana_kategori->kategori_adi}}</option>
                    @endforeach
                </select>

            </div>
            <button type="submit" class="btn btn-primary">Ara</button>
            <a href="{{route('yonetim.kategori')}}" class="btn btn-primary">Temizle</a>
        </form>
    </div>



    @include('layout.partials.alert')
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Üst Kategori</th>
                <th>Slug</th>
                <th>Kategori Adı</th>
                <th>Kayıt Tarihi</th>


            </tr>
            </thead>
            <tbody>
            @if(count($list)==0)
                <tr>
                    <td colspan="6">Kategori Bulunamadı</td>
                </tr>
            @endif

            @foreach($list as $entry)
                <tr>
                    <td>{{$entry->id}}</td>
                    <td>{{$entry->ust_kategori->kategori_adi}}</td>
                    <td>{{$entry->slug}}</td>
                    <td>{{$entry->kategori_adi}}</td>
                    <td>{{$entry->created_at}}</td>
                    <td>

                    <td style="width: 100px">
                        <a href="{{route('yonetim.kategori.duzenle',$entry->id)}}" class="btn btn-xs btn-success"
                           data-toggle="tooltip" data-placement="top"
                           title="Düzenle">
                            <span class="fa fa-pencil"></span>
                        </a>
                        <a href="{{route('yonetim.kategori.sil',$entry->id)}}" class="btn btn-xs btn-danger"
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
