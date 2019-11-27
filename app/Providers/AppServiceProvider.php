<?php

namespace App\Providers;

use App\Ayar;
use App\Kategori;
use App\Kullanici;
use App\Siparis;
use App\Urun;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      /*  $bitis_zamani = now()->addMinutes(10);
        $istatistikler=Cache::remember('istatistikler',$bitis_zamani,function (){//remember fonksiyonu cache istatistikler alanı varsa cacheden çekiyor yoksa  funtion ile oluşturulmasını sağlıyor
            return['bekleyen_siparis' => Siparis::where('durum', 'Siparişiniz Alındı')->count(),
                'tamamlanan_siparis' => Siparis::where('durum', 'Siparişiniz Tamamlandı')->count(),
                'tum_siparisler'=>Siparis::count(),
                'toplam_urun' => Urun::all()->count(),
                'toplam_kullanici' => Kullanici::all()->count()];
        });
        View::share('istatistikler',$istatistikler);//Tüm view dosyalarını kullanıyoruz*/
        //yada
        View::composer(['yonetim.*'],function ($view)//sadece belirttiğimiz view dosyaları kullanılıyor
        { $bitis_zamani = now()->addMinutes(10);
            $istatistikler=Cache::remember('istatistikler',$bitis_zamani,function (){//remember fonksiyonu cache istatistikler alanı varsa cacheden çekiyor yoksa  funtion ile oluşturulmasını sağlıyor
                return['bekleyen_siparis' => Siparis::where('durum', 'Siparişiniz Alındı')->count(),
                    'tamamlanan_siparis' => Siparis::where('durum', 'Sipariş Tamamlandı')->count(),
                    'tum_siparisler'=>Siparis::count(),
                    'toplam_urun' => Urun::count(),
                    'toplam_kategori'=>Kategori::count(),
                    'toplam_kullanici' => Kullanici::count()];
            });
            $view->with('istatistikler',$istatistikler);


            //Ayar Yönetimi/2.Yöntem diğeri helpers dosyası oluşturma//
            //Veritabanaındaki ayarların Config dosyasına aktarımı için
//            foreach (Ayar::all() as $ayar)
//            {
//                Config::set('ayar.'.$ayar->anahtar,$ayar->deger);//'ayar.' ön ek
//            }
        });
    }
}
