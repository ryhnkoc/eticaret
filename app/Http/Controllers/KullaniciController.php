<?php

namespace App\Http\Controllers;

use App\Kullanici;
use App\Mail\KullaniciKayitMail;
use App\Sepet;
use App\SepetUrun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Cart;

class KullaniciController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except('oturumukapat');
        //Bu yapıcı fonksiyon ile sadece kullanıcı girişi yapmamış olanların görmesine izin veriyoruz /except ile bundan hariç tutduğumuz metodu yazıyoruz
    }
    public function giris_form()
    {
        return view('kullanici.oturumac');
    }

//Oturum acma işlemlri yapılacak
    public function giris()
    {
       $this->validate(request(),
           [
               'email'=>'required|email',
               'sifre'=>'required'
           ]);
       if(auth()->attempt(['email'=>request('email'),'password'=>request('sifre')]))
       {
           request()->session()->regenerate();//requestin session bilgisi yenileniyor ve intend edilen sayfaya yönlendiriliyor

           //Session-Sepet ve Veritabaı Sepet i senkronize etme
           $aktif_sepet_id=Sepet::firstOrCreate(['kullanici_id'=>auth()->id()])->id;
           session()->put('aktif_sepet_id');//aktif_sepet_id bilgisini sessiona atmak için put metodunu kullanıyoruz
           if(Cart::count()>0)
           {//Bu blokta sessionda Cart kütüphanesi ile spete eklenen ürün varsa (güncelleme),veritabanında güncelleme yapacağız.
               foreach(Cart::content() as $cartItem)
               {
                   SepetUrun::updateOrCreate(
                       [
                           'sepet_id'=>$aktif_sepet_id,'urun_id'=>$cartItem->id
                       ],
                       [
                           'adet'=>$cartItem->qty,'fiyati'=>$cartItem->price,'durum'=>'Beklemede'
                       ]
                   );
               }
           }
           //Sessionda bulunanlar temizliyoruz
           Cart::destroy();
           //Temizlinen sessiona veritabanından urunleri çekerek toplu olarak atacağız
           $sepetUrunler=SepetUrun::with('urun')->where('sepet_id',$aktif_sepet_id)->get();//Eager Loading yöntemiyle çektik
           //Daha sonra $spetUrunlerdeki tüm ürünleri cart kütüphanesi ile sessiona ekliyoruz
           foreach($sepetUrunler as $sepetUrun)
           {
               Cart::add($sepetUrun->urun->id,$sepetUrun->urun->urun_adi,$sepetUrun->adet,$sepetUrun->fiyati);
           }
           return redirect()->intended('/');
       }
        else{
            $errors=['email'=>'Hatalı Giriş'];
            return back()->withErrors($errors);//back ile giriş yapmaya çalıştığımız sayfaya geri döndürüyor
        }
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
        else//Eğer kullanıcıya ulaşamazsa
        {
            return redirect()->to('/anasayfa')->with('mesaj','Kullanıcı Kaydı Bulunamadı')->with('mesaj_tur','warning');
        }
    }

    public function oturumukapat()
    {
        auth()->logout();
        request()->session()->flush();//session bilgilerini siliyoruz
        request()->session()->regenerate();//session ıd sıfırlanıyor
        return redirect()->route('anasayfa');


    }
}
