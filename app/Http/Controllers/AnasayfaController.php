<?php

namespace App\Http\Controllers;

use App\Kategori;

use Illuminate\Http\Request;

class AnasayfaController extends Controller
{
    public function index()
    {
        //$kategoriler=Kategori::all()->take(8);//Db den kategroileri çekiyoruz-take->ile veritabanından kaç kayıdı çekeceğimizi belirtiyoruz
        $kategoriler=Kategori::whereRaw('ust_id is null')->take(8)->get();//ust ıdlerin null olanları getir diyoruz ve filtreleme yaptığımız için get()metodunu kullanıyoruz
        return view('anasayfa',compact('kategoriler'));
    }
}
