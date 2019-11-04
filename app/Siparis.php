<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siparis extends Model
{
   protected $table='siparis';
   protected $fillable=['sepet_id','siparis_tutari','banka','taksit_sayisi','durum','adsoyad','telefon','ceptelefon'];

   public function sepet()
   {
       return $this->belongsTo('App\Sepet');
   }
}
