<?php

namespace App;
use App\Urun;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UrunDetay extends Model
{
    use SoftDeletes;//Model dosyamızın soft delete yapısıyla çalışması için bu kodu kullanıyoruz
    protected $table='urun_detay';
    //protected $fillable=['kategori_adı','slug'];
    protected  $guarded=[];//tüm kolon değerlerini istediğimiz gibi tabloya ekleyebiliriz fillable yazmamıza gerek yok

    public  $timestamps=false;//Eğer created at ve updeted at fonk kullnamka istemiyorsak model dosyamız içerisinde bunu belirtmeliyiz

    public function urun()
    {
        return $this->belongsTo('App\Urun');
    }
}
