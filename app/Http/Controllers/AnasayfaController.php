<?php

namespace App\Http\Controllers;

use App\Kategori;
use App\Urun;
use App\UrunDetay;
use Illuminate\Http\Request;

class AnasayfaController extends Controller
{
    public function index()
    {
        //$kategoriler=Kategori::all()->take(8);//Db den kategroileri çekiyoruz-take->ile veritabanından kaç kayıdı çekeceğimizi belirtiyoruz
        $kategoriler=Kategori::whereRaw('ust_id is null')->take(8)->get();//ust ıdlerin null olanları getir diyoruz ve filtreleme yaptığımız için get()metodunu kullanıyoruz
        $urunler_slider=UrunDetay::with('urun')->where('goster_slider',1)->take(get_ayar('anasayfa_slider_urun_adet'))->get();
        //take(config('ayar.anasayfa_slider_urun_adet') de Config dosyasına atıldığında kullanılıyor
        $urun_gunun_firsati=Urun::select('urun.*')
        ->join('urun_detay','urun_detay.urun_id','urun_id')
        ->where('urun_detay.goster_gunun_firsati',1)
        ->orderBy('updated_at','desc')
        ->first();//first sıralama yaptıktan sonra enüst değerin alınmasını sağlayacak


        $urunler_one_cikan=UrunDetay::with('urun')->where('goster_one_cikan',1)->take(get_ayar('anasayfa_liste_urun_adet'))->get();
        $urunler_cok_satan=UrunDetay::with('urun')->where('goster_cok_satan',1)->take(get_ayar('anasayfa_liste_urun_adet'))->get();
        $urunler_indirimli=UrunDetay::with('urun')->where('goster_indirimli',1)->take(get_ayar('anasayfa_liste_urun_adet'))->get();
        return view('anasayfa',compact('kategoriler','urunler_slider','urun_gunun_firsati','urunler_one_cikan','urunler_cok_satan','urunler_indirimli'));
    }
}
