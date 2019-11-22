@extends('layout.master')
@section('title','Sepet')
@section('content')
    <div class="container">
        <div class="bg-content">
            <h2>Sepet</h2>
            @include('layout.partials.alert')

            @if(count(Cart::content())>0)
            <table class="table table-bordererd table-hover">
                <tr>
                    <th colspan="2">Ürün</th>
                    <th>Adet Fiyatı</th>
                    <th>Adet</th>
                    <th>Tutar</th>
                </tr>

                @foreach(Cart::content() as $UrunCartItem)<!--Septtki Tüm Ürünleri Çekiyoruz-->
                <tr>

                        <td style="width:120px">
                            <a href="#">
                                <img src="http://lorempixel.com/120/100/food/2"> </a>
                        </td>

                    <td>

                        <a href="#">{{$UrunCartItem->name}}</a>

                        <form action="{{route('sepet.kaldir',$UrunCartItem->rowId)}}" method="post"><!--Kütüphane sepete eklenen ürünler için rowId adında yeni bir Id değeri oluşturuyor-->
                        @csrf
                        @method('DELETE')<!--Dlete metoduyal route gönderileck bir form olduğunu belirtiyoruz-->
                            <input type="submit" class="btn btn-danger brn-xs" value="Sepetten Kaldır">
                        </form>

                    </td>


                    <td>{{$UrunCartItem->price}}₺</td>
                    <td>
                        <a href="#" class="btn btn-xs btn-default urun-adet-azalt" data-id="{{$UrunCartItem->rowId}}" data-adet="{{$UrunCartItem->qty-1}}">-</a>
                        <span style="padding: 10px 20px">{{$UrunCartItem->qty}}</span><!--Adet Bilgisi için qty kullanıyoruz-->
                        <a href="#" class="btn btn-xs btn-default urun-adet-artir" data-id="{{$UrunCartItem->rowId}}" data-adet="{{$UrunCartItem->qty+1}}">+</a>
                    </td>
                    <td class="text-right"> {{$UrunCartItem->subtotal}}₺</td>
                    <td>
                        <a href="#">Sil</a>
                    </td>
                </tr>
                @endforeach
                <tr>

                    <th colspan="4" class=text-right">Alt Toplam</th>
                    <th class=text-right">{{Cart::subtotal()}}₺</th><!--Sepetedeki Tüm Ürünlere Ait Toplam Tutarı Gösteriyor-->

                </tr>

                <tr>

                    <th colspan="4" class=text-right">KDV</th>
                    <th class=text-right">{{Cart::tax()}}₺</th><!--Sepetteki Tüm Ürünlerin Kdvlerini hespalıyor-->

                </tr>

                <tr>

                    <th colspan="4" class=text-right">Genel Toplam</th>
                    <th class=text-right">{{Cart::total()}}₺</th>

                </tr>
            </table>
               <form action="{{route('sepet.bosalt')}}" method="post">
                   @csrf
                   @method('DELETE')
                   <input type="submit" class="btn btn-info pull-left" value="Sepeti Boşalt">
               </form>

                <a href="{{route('odeme')}}" class="btn btn-success pull-right btn-lg">Ödeme Yap</a>
            @else
                <p>Sepetinizde Ürün Yoktur</p>
            @endif

        </div>
    </div>
@endsection
@section('footer')
    <script>
        $(function()
        {
            $('.urun-adet-artir,.urun-adet-azalt').on('click',function(){

                var id=$(this).attr('data-id');
                var adet=$(this).attr('data-adet');

                $.ajax({
                    type:'PATCH',//gnelde patche type bir veri güncellenirken kullanılıyor
                    url:'{{url('sepet/guncelle')}}/'+ id,
                    data:{adet:adet},
                    success:function(result)
                    {
                        window.location.href='/sepet';
                    }
                });
            });

        });
    </script>
@endsection
