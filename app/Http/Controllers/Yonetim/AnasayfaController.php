<?php


namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Kullanici;
use App\Siparis;
use App\Urun;
use Cache;
use Illuminate\Support\Facades\DB;

class AnasayfaController extends Controller
{
    public function index()
    {/*1.Yöntem Cache veri aktarma ve cacheden veri çekme için
        if(!Cache::has('istatistikler')) {//Cache de istatistikler şeklinde bir yapı varmı yokmu diye ilk blok yok da yapılacaklar için
            $istatistikler = [//Burada 'bekleyen_siparis','tamamlanan_siparis','toplam_urun','toplam_kullanici' istatistikler dizisinin keyleri oluyor
                'bekleyen_siparis' => Siparis::where('durum', 'Siparişiniz Alındı')->count(),//Bu şekilde yani count ile sorgu sonucunda dönen kayıtların toplam sayısı alınıyor.
                'tamamlanan_siparis' => Siparis::where('durum', 'Siparişiniz Tamamlandı')->count(),
                'toplam_urun' => Urun::all()->count(),
                'toplam_kullanici' => Kullanici::all()->count()];

            $bitis_zamani = now()->addMinutes(10);//Bitis zamanını şuanki zamandan 10 dk sonrasını verdik.
            Cache::put('istatistikler', $istatistikler, $bitis_zamani);//Put ile cache alanına belirtilen yapı kaydedilir|Bitiş zamanı verinin cache ne kadar sür tutulacağını belirtir
        }else//Eğr cache istatistikler varsa
        {

            $istatistikler=Cache::get('istatistikler');//Cacheden veri çekmemizi sağlar.
        }
         */


        //2.Yöntem
        /*$bitis_zamani = now()->addMinutes(10);
        $istatistikler=Cache::remember('istatistikler',$bitis_zamani,function (){//remember fonksiyonu cache istatistikler alanı varsa cacheden çekiyor yoksa  funtion ile oluşturulmasını sağlıyor
            return['bekleyen_siparis' => Siparis::where('durum', 'Siparişiniz Alındı')->count(),
                'tamamlanan_siparis' => Siparis::where('durum', 'Siparişiniz Tamamlandı')->count(),
                'toplam_urun' => Urun::all()->count(),
                'toplam_kullanici' => Kullanici::all()->count()];
        });*/
        $cok_satan_urunler = DB::select(
            "SELECT u.urun_adi,SUM(su.adet) adet
            FROM siparis si
             INNER JOIN sepet s ON s.id=si.sepet_id
             INNER JOIN sepet_urun su ON s.id=su.sepet_id
             INNER JOIN urun u ON u.id=su.urun_id
             GROUP BY u.urun_adi
             ORDER BY SUM(su.adet)DESC
            ");
//        $aylara_gore_satislar=DB::select(TODO: hata veriyor
//            "SELECT  TO_CHAR(si.created_at,'YYYY/MM/DD') ay,SUM(su.adet) adet
//            FROM siparis si
//             INNER JOIN sepet s on s.id=si.sepet_id
//             INNER JOIN sepet_urun su on s.id=su.sepet_id
//             INNER JOIN urun u on u.id=su.urun_id
//             GROUP BY TO_CHAR(si.created_at,'YYYY/MM/DD')
//             ORDER BY TO_CHAR(si.created_at,'YYYY/MM/DD')
//            ");

        return view('yonetim.anasayfa',compact('cok_satan_urunler'/*,'aylara_gore_satislar'*/));
    }
}
