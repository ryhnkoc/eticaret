<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Kategori;
use App\Siparis;
use App\Urun;
use App\UrunDetay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class SiparisController extends Controller
{
    public function index()
    {
        if (request()->filled('aranan')) {
            request()->flash();
            $aranan = request('aranan');
            $list = Siparis::with('sepet.kullanici')->where('adsoyad', 'like', "%$aranan%")
                ->orWhere('id',$aranan)
                ->paginate(8)
                ->appends('aranan', $aranan);

        } else {
            $list =Siparis::with('sepet.kullanici')->paginate(8);
        }
        return view('yonetim.siparis.index', compact('list'));

    }

    public function form($id = 0)
    {
        if ($id > 0) {
            $entry = Siparis::with('sepet.sepet_urunler.urun')->find($id);
       }
        return view('yonetim.siparis.form', compact('entry'));
    }

    public function kaydet($id = 0)
    {
        $this->validate(\request(), [
            'adsoyad' => 'required',
            'telefon' => 'required',
            'durum'=>'required'
        ]);
        $data = \request()->only('adsoyad', 'telefon', 'ceptelefon','durum');

        if ($id > 0) {
            $entry = Siparis::where('id', $id)->firstOrFail();
            $entry->update($data);

        }


        return redirect()
            ->route('yonetim.urun.duzenle', $entry->id)
            ->with('mesaj', ('Güncellendi'))
            ->with('mesaj_tur', 'success');
    }

    public function sil($id)
    {
        $siparis = Siparis::find($id);
        $siparis->delete();
        return redirect()
            ->route('yonetim.siparis')
            ->with('mesaj', 'Kayıt Silindi')
            ->with('mesaj_tur', 'success');

    }

}
