<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Urun extends Model
{
    use SoftDeletes;//Model dosyamızın soft delete yapısıyla çalışması için bu kodu kullanıyoruz
    protected $table='urun';
    protected  $guarded=[];//tüm kolon değerlerini istediğimiz gibi tabloya ekleyebiliriz fillable yazmamıza gerek yok



    public function kategoriler()
    {
        return $this->belongsToMany('App\Kategori','kategori_urun');//ÜRüne ait kategorileri çekiyoruz
    }
    protected function bootIfNotBooted()
    {
        parent::bootIfNotBooted(); //
    }
    public function detay()//Bu fonksiyon ile urun modeli içrisnden urune ait detay bilgilerini çekebilceğiz
    {
        return $this->hasOne('App\UrunDetay')->withDefault();//Eğer yeni eklenne ürün ürün detay da kayıtlı değils default yani boş bir değer ile geri dönecek

    }
}
