<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//
//Route::get(['prefix'=>'yonetim','namespace'=>'Yonetim'],function(){
//    Route::get('/',function(){
//        return "Admin";
//    });
//    Route::get('/oturumac','KullaniciController@oturumac')->name('yonetim.oturumac');
////Eski kullanım
//});
Route::namespace('Yonetim')->prefix('yonetim')->group(function () {
    Route::redirect('/','/yonetim/oturumac');
    Route::get('/oturumukapat','KullaniciController@oturumukapat')->name('yonetim.oturumukapat');
    Route::group(['middleware'=>'yonetim'],function (){
        Route::get('/anasayfa','AnasayfaController@index')->name('yonetim.anasayfa');
        //yonetim/kullanici
        Route::group(['prefix'=>'kullanici'],function(){
            Route::match(['get','post'],'/','KullaniciController@index')->name('yonetim.kullanici');
            Route::get('/yeni','KullaniciController@form')->name('yonetim.kullanici.yeni');
            Route::get('/duzenle/{id}','KullaniciController@form')->name('yonetim.kullanici.duzenle');
            Route::post('/kaydet/{id}','KullaniciController@kaydet')->name('yonetim.kullanici.kaydet');
            Route::get('sil/{id}','KullaniciController@sil')->name('yonetim.kullanici.sil');
        });

        //yonetim/kategori
        Route::group(['prefix'=>'kategori'],function(){
            Route::match(['get','post'],'/','KategoriController@index')->name('yonetim.kategori');
            Route::get('/yeni','KategoriController@form')->name('yonetim.kategori.yeni');
            Route::get('/duzenle/{id}','KategoriController@form')->name('yonetim.kategori.duzenle');
            Route::post('/kaydet/{id}','KategoriController@kaydet')->name('yonetim.kategori.kaydet');
            Route::get('sil/{id}','KategoriController@sil')->name('yonetim.kategori.sil');
        });
        //yonetim/urun
        Route::group(['prefix'=>'urun'],function(){
            Route::match(['get','post'],'/','UrunController@index')->name('yonetim.urun');
            Route::get('/yeni','UrunController@form')->name('yonetim.urun.yeni');
            Route::get('/duzenle/{id}','UrunController@form')->name('yonetim.urun.duzenle');
            Route::post('/kaydet/{id}','UrunController@kaydet')->name('yonetim.urun.kaydet');
            Route::get('sil/{id}','UrunController@sil')->name('yonetim.urun.sil');
        });

        //yonetim/siparis
        Route::group(['prefix'=>'siparis'],function(){
            Route::match(['get','post'],'/','SiparisController@index')->name('yonetim.siparis');
            Route::get('/yeni','SiparisController@form')->name('yonetim.siparis.yeni');
            Route::get('/duzenle/{id}','SiparisController@form')->name('yonetim.siparis.duzenle');
            Route::post('/kaydet/{id}','SiparisController@kaydet')->name('yonetim.siparis.kaydet');
            Route::get('sil/{id}','SiparisController@sil')->name('yonetim.siparis.sil');
        });
    });

    Route::match(['get','post'],'/oturumac','KullaniciController@oturumac')->name('yonetim.oturumac');//match fonkisyonu birden fazla metod tipine göre bir sayfayı açmayı sağlıyor

});

Route::get('/anasayfa', 'AnasayfaController@index')->name('anasayfa');//Anasayfa içerisindeki index metodu çağırılacaktır.
Route::get('/kategori/{slug_kategoriadi}','KategoriController@index')->name('kategori');
Route::get('/urun/{slug_urunadi}','UrunController@index')->name('urun');

Route::group(['prefix'=>'sepet'],function(){
    Route::get('/','SepetController@index')->name('sepet');
    Route::post('/ekle','SepetController@ekle')->name('sepet.ekle');
    Route::delete('/kaldir/{rowid}','SepetController@kaldir')->name('sepet.kaldir');
    Route::delete('/bosalt','SepetController@bosalt')->name('sepet.bosalt');
    Route::patch('/guncelle/{rowid}','SepetController@guncelle')->name('sepet.guncelle');
});

Route::get('/odeme/','OdemeController@index')->name('odeme');
Route::post('/odeme','OdemeController@odemeyap')->name('odemeyap');
Route::group(['middleware'=>'auth'],function (){
    Route::get('/siparisler/','SiparislerController@index')->name('siparisler');
    Route::get('/siparisler/{id}','SiparislerController@detay')->name('siparis');
});


Route::post('/ara','UrunController@ara')->name('urun_ara');
Route::get('/ara','UrunController@ara')->name('urun_ara');

Route::group(['prefix'=>'kullanici'],function(){
    Route::get('/oturumac','KullaniciController@giris_form')->name('kullanici.oturumac');
    Route::post('/oturumac','KullaniciController@giris');

    Route::post('/oturumukapat','KullaniciController@oturumukapat')->name('kullanici.oturumukapat');
    Route::get('/kaydol','KullaniciController@kaydol_form')->name('kullanici.kaydol');
    Route::post('/kaydol','KullaniciController@kaydol');

    Route::get('aktiflestir/{anahtar}','KullaniciController@aktiflestir')->name('aktiflestir');
});

Route::get('/', 'AnasayfaController@index');

Route::get('/test/mail',function()
{
    $kullanici=\App\Kullanici::find(1);
    return new App\Mail\KullaniciKayitMail($kullanici);
});
