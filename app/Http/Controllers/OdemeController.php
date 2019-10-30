<?php

namespace App\Http\Controllers;

use App\Siparis;
use Illuminate\Http\Request;
use Cart;
class OdemeController extends Controller
{
    public function index()
    {
        if(!auth()->check())
        {
           return redirect()->route('kullanici.oturumac')
               ->with('mesaj_tur','info')
               ->with('mesaj','Ödeme İşlemi İçin Oturum Açmanız yada Kullanıcı Kaydı Yapmanız Gerekir');
        }
        elseif (count(Cart::content())==0)
        {
            return redirect()->route('anasayfa')
                ->with('mesaj_tur','info')
                ->with('mesaj','Ödeme İşlemi İçin Sepetinizde Ürün Bulunmalıdır');
        }
        $kullanici_detay=auth()->user()->detay;


        return view('odeme',compact('kullanici_detay'));
    }

    public function odemeyap()
    {
        $siparis=request()->all();
        $siparis['sepet_id']=session('aktif_sepet_id');
        $siparis['banka']='Türkiye İş Bankası';
        $siparis['taksit_sayisi']=1;
        $siparis['durum']='Siparişiniz Alındı';
        $siparis['siparis_tutari']=Cart::subtotal();
        Siparis::create($siparis);
        Cart::destroy();
        session()->forget('aktif_sepet_id');
        return redirect()->route('siparisler')
            ->with('mesaj_tur','success')
            ->with('mesaj','Ödemeniz Başarılı Bir Şekilde Gerçekleştirildi');


    }
}
