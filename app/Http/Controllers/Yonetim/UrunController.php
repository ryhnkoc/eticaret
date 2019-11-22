<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Kategori;
use App\Urun;
use App\UrunDetay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class UrunController extends Controller
{
    public function index()
    {
        if (request()->filled('aranan')) {
            request()->flash();//formdan gönderilen vrilerin session içinde saklanmasını sağlıyor
            $aranan = request('aranan');
            $list = Urun::where('urun_adi', 'like', "%$aranan%")
                ->orWhere('aciklama', 'like', "%$aranan%")
                ->paginate(8)
                ->appends('aranan', $aranan);//arama işlemi yaparken aranan kayıt ilk sayfada gösteriliyor ancak diğer sayfalarda arama kaydı tutulmayıp arama işlem sonucu gözükmüyor bunu engellemek için yapıldı.

        } else {
            $list = Urun::paginate(8);
        }
        return view('yonetim.urun.index', compact('list'));

    }

    public function form($id = 0)
    {
        $entry = new Urun();//eğr ıd değeri gelmezse bir kullanıcı olmayacağı ancak bunu form php ye göndereceğimiz için başta boş bir kullanıcıdan entry objesi oluşturuyoruz
        $urun_kategorileri = [];
        if ($id > 0) {
            $entry = Urun::find($id);
            $urun_kategorileri = $entry->kategoriler->pluck('kategori_id')->all();//bir tablodaki sadece bir kolonu almamızı pluck() sağlıyor
        }
        $kategoriler = Kategori::all();
        return view('yonetim.urun.form', compact('entry', 'kategoriler', 'urun_kategorileri'));
    }

    public function kaydet($id = 0)
    {
        $this->validate(\request(), [
            'urun_adi' => 'required',
            'fiyati' => 'required',
            'aciklama' => 'required',
            'slug' => 'unique:urun,slug'//TODO:Slug değerinde sorun var
        ]);
        $data = \request()->only('urun_adi', 'slug', 'aciklama', 'fiyati');
        if ((Urun::where('slug', $data['slug'])->first()) == true) {
            return back()->withInput()
                ->withErrors(['slug' => 'Slug Değeri Daha Önceden Kayıtlıdır']);
        } else {
            $newSlug = Str::slug(\request('urun_adi'));
            $data['slug'] = $newSlug;
        }

        $data_detay = \request()->only('goster_slider', 'goster_gunun_firsati', 'goster_one_cikan', 'goster_cok_satan', 'goster_indirimli');
        $kategoriler = \request('kategoriler');
        if ($id > 0) {
            $entry = Urun::where('id', $id)->firstOrFail();
            $entry->update($data);//update ve create dizi alır save() nesne alır
            $entry->detay()->update($data_detay);
            $entry->kategoriler()->sync($kategoriler);//güncellemede eklenen kategoriler eklenir yada çıkarılanları kaldırır.senkronize sağlar


        } else {
            $entry = Urun::create($data);
            $entry->detay()->create($data_detay);
            $entry->kategoriler()->attach($kategoriler);/*ürünün bulunduğu katgeoriler ekleniyor*/
        }

        if (\request()->hasFile('urun_resim')) {
            $this->validate(\request(), [
                'urun_resim' => 'image|mimes:jpg,png,jpeg,gif|max:2048'
            ]);
            $urun_resmi = request()->file('urun_resim');
            // $urun_resmi->extension();//gönderilen dosyanın uzantısını çekmemizi sağlar
            //  $urun_resmi->getClientOriginalName();//dosyanın bilgisayardaki ismini çekmemizi sağlar
            //$urun_resmi->hashName()Dosyanın ismi rastgele oluşturulur
            $dosya_adi = $urun_resmi->getClientOriginalName();
            if ($urun_resmi->isValid()) {//Gönderilen dosya ilk gecic bir yerde saklanır isValid ile bu geiçiçi yerde düzgün yüklenip yüklenmediği kontrol ediliyor
                $dosya=($urun_resmi->move(base_path('uploads/urunler'), $dosya_adi));
//              dd($dosya,$dosya_adi);
                $pic_urun_detay = UrunDetay::updateOrCreate([

                        'urun_id' =>$entry->id
                    ],
                    [
                        'urun_resim' =>$dosya_adi

                    ]);

            }
        }

        return redirect()
            ->route('yonetim.urun.duzenle', $entry->id)
            ->with('mesaj', ($id > 0 ? 'Güncellendi' : 'Kaydedildi'))
            ->with('mesaj_tur', 'success');


    }

    public function sil($id)
    {
        $urun = Urun::find($id);
        //attach/detach=>many to many olan tablolarad ekleme/silme işlemleri yapılıyor
        $urun->kategoriler->detach();

        $urun->detay()->delete();//birebir ilşkili tablo yapısı var kayıt siliniyor
        $urun->delete();
        return redirect()
            ->route('yonetim.urun')
            ->with('mesaj', 'Kayıt Silindi')
            ->with('mesaj_tur', 'success');

    }

}
