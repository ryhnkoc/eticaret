<h1>{{config('app.name')}}</h1>

<p>Merhaba {{$kullanici->adsoyad}} , Kaydınız Başarılı Bir Şekilde yapıldı</p>
<p>Kaydınızı aktifleştirmek için <a href="{{config('app.url')}}/kullanici/aktiflestir/{{$kullanici->aktivasyon_anahtari}}">Tıklayın</a></p>
