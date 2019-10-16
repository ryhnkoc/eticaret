<?php

namespace App\Http\Controllers;

use App\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index($slug_kategoriadi)
    {
        $kategori=Kategori::where('slug',$slug_kategoriadi)->firstOrFail();
        $alt_kategoriler=Kategori::where('ust_id',$kategori->id)->get();

        //Urun Listeleme
        $urunler=$kategori->urunler;// @todo: Salih Abi'ye sor
        return view('kategori',compact('kategori','alt_kategoriler','urunler'));

    }
}
