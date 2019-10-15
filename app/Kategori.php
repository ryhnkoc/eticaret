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
    const CREATED_AT = 'olusturulma_tarihi';
    const UPDATED_AT ='guncelleme_tarihi';
    const DELETED_AT='silinme_tarihi';
}
