<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use SoftDeletes;//Model dosyamızın soft delete yapısıyla çalışması için bu kodu kullanıyoruz
    protected $table='kategori';
    //protected $fillable=['kategori_adı','slug'];
    protected  $guarded=[];//tüm kolon değerlerini istediğimiz gibi tabloya ekleyebiliriz fillable yazmamıza gerek yok
    const CREATED_AT = 'created_at';
    const UPDATED_AT ='updated_at';
    const DELETED_AT='deleted_at';


    public function urunler()
    {
        return $this->belongsToMany('App\Urun','kategori_urun');
    }
}
