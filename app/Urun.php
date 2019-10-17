<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Urun extends Model
{
    use SoftDeletes;//Model dosyamızın soft delete yapısıyla çalışması için bu kodu kullanıyoruz
    protected $table='urun';
    protected  $guarded=[];//tüm kolon değerlerini istediğimiz gibi tabloya ekleyebiliriz fillable yazmamıza gerek yok
    const CREATED_AT = 'created_at';
    const UPDATED_AT ='updated_at';
    const DELETED_AT='deleted_at';


    public function kategoriler()
    {
        return $this->belongsToMany('App\Kategori','kategori_urun');
    }
    protected function bootIfNotBooted()
    {
        parent::bootIfNotBooted(); // TODO: Change the autogenerated stub
    }
    public function detay()
    {
        return $this->hasOne('App\UrunDetay');

    }
}
