@extends('yonetim.layouts.master')
@section('title','Kategori Yönetimi')
@section('content')
    <h1 class="page-header">Kategori Yönetimi</h1>

    <form method="post"
          action="{{@$entry->id > 0 ? route('yonetim.kategori.kaydet',@$entry->id):route('yonetim.kategori.kaydet',0)}}">
        @csrf
        @method('POST')
        <div class="pull-right">
            <button type="submit" class="btn btn-primary">{{@$entry->id > 0 ? "Güncelle":"Kaydet"}}</button>
        </div>
        <h3 class="sub-header">Kategori{{@$entry->id>0? "Düzenle":"Ekle"}}</h3>
        @include('layout.partials.errors')
        @include('layout.partials.alert')
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="ust_id">Üst Kategori</label>
                    <select id="ust_id" name="ust_id" class="form-control">
                        <option value="">Ana Kategori</option>
                        @foreach($kategoriler as $kategori)
                            <option value="{{$kategori->id}}">{{$kategori->kategori_adi}}</option>
                        @endforeach
                    </select>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="kategori_adi">Kategori Adı</label>
                    <input type="text" class="form-control" id="kategori_adi" name="kategori_adi"
                           value="{{old('kategori_adi',$entry->kategori_adi)}}" placeholder="Kategori Adı">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="hidden"name="original_slug" value="{{old('slug',$entry->slug)}}">
                    <input type="text" class="form-control" id="slug" name="slug" value="{{old('slug',$entry->slug)}}"
                           placeholder="Slug">
                </div>
            </div>
        </div>
    </form>
@endsection
