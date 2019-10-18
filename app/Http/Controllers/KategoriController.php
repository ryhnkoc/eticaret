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


        //Çok Satanalar ve Yeni Ürünlr
        $order=request('order');

        if($order=='coksatanlar')
        {

            $urunler=$kategori->urunler()
                ->distinct()
                ->join('urun_detay','urun_detay.urun_id','urun.id')
            ->where('urun_detay.goster_cok_satan',true)
            ->paginate(2);
        }
        else if($order=='yeni')
        {
            $urunler=$kategori->urunler()->distinct()->orderBy('created_at','desc')->paginate(2);
        }
        else{ //Urun Listeleme
            $urunler=$kategori->urunler()->paginate(2);}

        return view('kategori',compact('kategori','alt_kategoriler','urunler'));

    }
}
