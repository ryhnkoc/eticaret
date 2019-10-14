<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnasayfaController extends Controller
{
    public function index()
    {$isim='Reyyan';
    $soyisim='Koç';
        return view('anasayfa')->with(['isim'=>$isim,'soyisim'=>$soyisim]);
    }
}
