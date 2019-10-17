<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiparislerController extends Controller
{
    public function index()
    {
        return view('siparis');
    }
    public function detay($id)
    {
        return view('siparis_detay')->with('id',$id);
    }
}
