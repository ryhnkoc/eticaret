<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KullaniciDetay extends Model
{
    protected $table='kullanici_detay';
    public $timestamps=false;
    protected $guarded=[];

    public function kullanici()//:TODO Bu kısım tam oturmadı Kullanıcı sayfasıyla bağı var--İncele
    {
        return $this->belongsTo('App\Kullanici');
    }
}
