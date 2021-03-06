<?php

namespace App\Http\Controllers;

use App\Kategori;
use App\Urun;
use Illuminate\Http\Request;

class UrunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug_urunadi)
    {

        $urun=Urun::whereSlug($slug_urunadi)->firstorFail();
         return  view('urun',compact('urun'));
    }

    //Ara fonksiyonu
    public function ara()
    {
        $aranan=request()->input('aranan');

//        dd(Urun::get());
        $urunler=Urun::where('urun_adi','ilike',"%$aranan%")
        ->orWhere('aciklama','ilike',"%$aranan%")
        ->paginate(3);//aradığımız ürünleri sayfalandırmak için kullanıyoruz
        request()->flash();
        return view('arama',compact('urunler'));
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\urun  $urun
     * @return \Illuminate\Http\Response
     */
    public function show(urun $urun)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\urun  $urun
     * @return \Illuminate\Http\Response
     */
    public function edit(urun $urun)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\urun  $urun
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, urun $urun)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\urun  $urun
     * @return \Illuminate\Http\Response
     */
    public function destroy(urun $urun)
    {
        //
    }
}
