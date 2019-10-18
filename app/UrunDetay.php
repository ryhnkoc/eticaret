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
    const CREATED_AT = 'created_at';
    const UPDATED_AT ='updated_at';
    const DELETED_AT='deleted_at';
    public  $timestamps=false;//Eğer created at ve updeted at fonk kullnamka istemiyorsak model dosyamız içerisinde bunu belirtmeliyiz

    public function urun()
    {
        return $this->belongsTo('App\Urun');
    }
}
