<?php

namespace App\Http\Controllers;

use App\Kategori;

use Illuminate\Http\Request;

class AnasayfaController extends Controller
{
    public function index()
    {
        $kategoriler=Kategori::all()->take(8);//Db den kategroileri çekiyoruz-take->ile veritabanından kaç kayıdı çekeceğimizi belirtiyoruz
        return view('anasayfa',compact('kategoriler'));
    }
}
