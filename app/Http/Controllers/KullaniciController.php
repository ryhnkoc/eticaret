<?php

namespace App\Http\Controllers;

use App\Kullanici;
use App\Mail\KullaniciKayitMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class KullaniciController extends Controller
{
    public function giris_form()
    {
        return view('kullanici.oturumac');
    }

    public function kaydol_form()
    {
        return view('kullanici.kaydol');
    }

    public function kaydol()
    {
        /*Validation İşlemlri*/
        $this->validate(request(),
            [/*hangi isteği doğruyacağımıza ilk parametre olarak yazıyoruz ,ikinci parametre dizi olarak kuralları tanımlıyoruz*/
                'adsoyad'=>'required|min:5|max:60',
                'email'=>'required|email|unique:kullanici',//unique kullanıcı tablosuna  bakıp kontrol edecek tekmi diye
                'sifre'=>'required|confirmed|min:5|max:15'
            ]);
            /*resources->lang->eng klasörü altında validatio.php içindeki tanımlamaları değiştirerek hata mesajlarını türkçe gösterebiliriz*/

        /*Request ile gelenlerin veri tabanına kaydı yapılıyor*/
        $kullanici=Kullanici::create([
            'adsoyad'=>request('adsoyad'),
            'email'=>request('email'),
            'sifre'=>Hash::make(request('sifre')),
            'aktivasyon_anahtari'=>Str::random(60),
            'aktif_mi'=>0
        ]);

        //Mail gönderme işlemini tetikleyeceğiz
        Mail::to(request('email'))->send(new KullaniciKayitMail($kullanici));

        //Kullanıcı Kaydı sırasında aktivasyon işlemlerini yapabiliyoruz,Bu şwkilde aktif olanalr girebilecek aslında bu şekilde mail adresini doğrulamış olacağız hemde aktivasyonunu yapmış olacağız
        auth()->login($kullanici);
        return redirect()->route('anasayfa');
    }

    //Aktifleştirme işlemleri yapılıyor
    public function aktiflestir($anahtar)
    {
        $kullanici=Kullanici::where('aktivasyon_anahtari',$anahtar)->first();//kolon adı,gelen değer first() ile ilk kayıt alınıyor

        if(!is_null($kullanici))
        {
            $kullanici->aktivasyon_anahtari=null;
            $kullanici->aktif_mi=1;
            $kullanici->save();//save ile yapılan değişiklikleri yada yeni oluşturulan kayıtları kaydediyoruz
            return redirect()->to('/anasayfa')->with('mesaj','Kullanıcı Kaydınız Aktifleştirildi')->with('mesaj_tur','success');   //bu şekilde de yönlendirme yapabiliyoruz
            //with fonksiyonu session değerleri olarak göndermemizi sağlıyor.With komutu ile gönderilern session değerleri otomatik olarak silinmektedir

        }
    }
}
