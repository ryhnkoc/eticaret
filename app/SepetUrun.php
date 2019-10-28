<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SepetUrun extends Model
{
    protected $table="sepet_urun";
    protected $guarded=[];
    //
    public function urun()
    {//Urune erişilecek ilişki yapısını oluşturuyoruz
        //SepetUrunden Urun tablosuna ulaşmak istiyoruz
        return $this->belongsTo('App\Urun');
    }

}
