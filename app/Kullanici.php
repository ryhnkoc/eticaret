<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Kullanici extends Authenticatable
{
    use Notifiable;


    protected $table = 'kullanici';
    protected $fillable = [
        'adsoyad', 'email', 'sifre', 'aktif_mi', 'aktivasyon_anahtari','yonetici_mi'
    ];

    protected $hidden = ['sifre', 'aktivasyon_anahtari'];
    public $timestamps = false;//Eğer created at ve updeted at fonk kullnamka istemiyorsak model dosyamız içerisinde bunu belirtmeliyiz

    public function getAuthPassword()
    {
        return $this->sifre;//DB deki sifre alanını password olarak görmesi daha doğrusu eşleştirmesi için gerekli  gAP override ediyoruz
    }

    public function detay()
    {
        return $this->hasOne('App\KullaniciDetay')->withDefault();
    }

}
