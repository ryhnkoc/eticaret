<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illıminate\Foundation\Auth\User as Authenticatable;


class Kullanici extends Authenticatable
{
    use Notifiable;


    protected $table = 'kullanici';
    protected $fillable = [
        'adsoyad', 'email', 'sifre', 'aktif_mi', 'aktivasyon_anahtari'
    ];

    protected $hidden = ['sifre', 'aktivasyon_anahtari'];
    public $timestamps = false;//Eğer created at ve updeted at fonk kullnamka istemiyorsak model dosyamız içerisinde bunu belirtmeliyiz


}
