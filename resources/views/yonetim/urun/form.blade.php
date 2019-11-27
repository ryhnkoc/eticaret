@extends('yonetim.layouts.master')
@section('title','Ürün Yönetimi')
@section('content')
    <h1 class="page-header">Ürün Yönetimi</h1>

    <form method="post"
          action="{{@$entry->id > 0 ? route('yonetim.urun.kaydet',@$entry->id):route('yonetim.urun.kaydet',0)}}" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="pull-right">
            <button type="submit" class="btn btn-primary">{{@$entry->id > 0 ? "Güncelle":"Kaydet"}}</button>
        </div>
        <h3 class="sub-header">Ürün{{@$entry->id>0? "Düzenle":"Ekle"}}</h3>

        @include('layout.partials.errors')
        @include('layout.partials.alert')

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="urun_adi">Ürün Adı</label>
                    <input type="text" class="form-control" id="urun_adi" name="urun_adi"
                           value="{{old('urun_adi',$entry->urun_adi)}}" placeholder="Ürün Adı">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="hidden" name="original_slug" value="{{old('slug',$entry->slug)}}">
                    <input type="text" class="form-control" id="slug" name="slug" value="{{old('slug',$entry->slug)}}"
                           placeholder="Slug">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="aciklama">Ürün Açıklaması</label>
                    <textarea class="form-control" id="aciklama" name="aciklama"
                              value="{{old('aciklama',$entry->aciklama)}}" placeholder="Açıklama"></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fiyati">Fiyatı</label>
                    <input type="text" class="form-control" id="fiyati" name="fiyati"
                           value="{{old('fiyati',$entry->fiyati)}}" placeholder="Fiyatı">
                </div>
            </div>
        </div>
        <div class="checkbox">
            <label>
                <input type="hidden" name="goster_slider" value="false">
                <input type="checkbox" name="goster_slider"
                       value="true"{{old('goster_slider',$entry->detay->goster_slider)?'checked':''}}>Slider 'da Göster
            </label>

            <label>
                <input type="hidden" name="goster_gunun_firsati" value="false">
                <input type="checkbox" name="goster_gunun_firsati"
                       value="true"{{old('goster_gunun_firsati',$entry->detay->goster_gunun_firsati)?'checked':''}}>Günün
                Fırsatında Göster
            </label>

            <label>
                <input type="hidden" name="goster_one_cikan" value="false">
                <input type="checkbox" name="goster_one_cikan"
                       value="true"{{old('goster_one_cikan',$entry->detay->goster_one_cikan)?'checked':''}}>Öne Çıkan
                Alanında Göster
            </label>

            <label>
                <input type="hidden" name="goster_cok_satan" value="false">
                <input type="checkbox" name="goster_cok_satan"
                       value="true"{{old('goster_cok_satan',$entry->detay->goster_cok_satan)?'checked':''}}>Çok Satan
                Ürünlerde Göster
            </label>

            <label>
                <input type="hidden" name="goster_indirimli" value="false">
                <input type="checkbox" name="goster_indirimli"
                       value="true"{{old('goster_indirimli',$entry->detay->goster_indirimli)?'checked':''}}>İndirimli
                Ürünlerde Göster
            </label>
        </div>
        <div>
            <div class="row">
                <div class="col-md-6">
                    <label for="kategoriler">Kategoriler</label>
                    <select name="kategoriler[]" class="form-control" id="kategoriler" multiple>
                        @foreach($kategoriler as $kategori)
                            <option value="{{$kategori->id}}" {{collect(old('kategoriler',$urun_kategorileri))->contains($kategori->id)?'selected':''}}>{{$kategori->kategori_adi}}</option>
                        @endforeach
                    </select>
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            @if($entry->detay->urun_resim!=null)
                <img src="/uploads/urunler/{{$entry->detay->urun_resim}}" style="height:100px; margin-right:20px;" class="thumbnail pull-left">
            @endif
            <label for="urun_resmi">Ürün Resmi</label>
            <input type="file" id="urun_resim" name="urun_resim">

        </div>
    </form>
@endsection
@section('head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet"/>
@endsection
@section('footer')
    <script src="//cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(function () {
            $('#kategoriler').select2();
            var options={
                uiColor:'f4645f',
                language:'tr',
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
            }
            CKEDITOR.replace('aciklama',options);
        });
    </script>
@endsection
