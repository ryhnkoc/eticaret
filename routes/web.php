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

Route::get('/anasayfa', 'AnasayfaController@index')->name('anasayfa');//Anasayfa içerisindeki index metodu çağırılacaktır.
Route::get('/kategori/{slug_kategoriadi}','KategoriController@index')->name('kategori');
Route::get('/urun/{slug_urunadi}','UrunController@index')->name('urun');
Route::get('/sepet/','SepetController@index')->name('sepet');
Route::get('/odeme/','OdemeController@index')->name('odeme');
Route::get('/siparis/','SiparislerController@index')->name('siparisler');
Route::post('/ara','UrunController@ara')->name('urun_ara');
Route::get('/ara','UrunController@ara')->name('urun_ara');

Route::group(['prefix'=>'kullanici'],function(){
    Route::get('/oturumac','KullaniciController@giris_form')->name('kullanici.oturumac');
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
