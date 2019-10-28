<?php

namespace App\Http\Controllers;

use App\Sepet;
use App\SepetUrun;
use App\Urun;
use Cart;
use Validator;
use Illuminate\Http\Request;

class SepetController extends Controller
{
    public function index()
    {
        return view('sepet');
    }

    public function ekle()
    {
        $urun = Urun::find(request('id'));
        $options = $urun->slug;
        $cartItem = Cart::add(
            $urun->id, $urun->urun_adi, 1, $urun->fiyati
        /*  ['options' => $options]]*/
        );//Sepete ürünü eklemek için kullanıyoruz
        if (auth()->check())//bir kullanıcı girişi yapıldıysa
        {
            $aktif_sepet_id = session('aktif_sepet_id');
            if (!isset($aktif_sepet_id)) {
                $aktif_sepet = Sepet::create([
                    'kullanici_id' => auth()->id()
                ]);
                $aktif_sepet_id = $aktif_sepet->id;
                session()->put('aktif_sepet_id', $aktif_sepet_id);

            }
            SepetUrun::updateOrCreate(//ilk parametrede verilen filtre değerlere bakıyor ve kaydı bulursa ikinci parametre ile verilen değerlerle güncelliyor
                ['sepet_id'=>$aktif_sepet_id,'urun_id'=>$urun->id],//İlk db de bu kayıtlar varmı yokumu diye kontrolediyor
                //Varsa 2.parametredeki değerle güncelliyor
                //Eğer Yoksa sepet_id urun_id ve durum bilgisiyle yeni bir kayıt oluşturuyor

                ['adet'=>$cartItem->qty,'fiyati'=>$urun->fiyati,'durum'=>'Beklemede']
            );

        }
        return redirect()->route('sepet')//Sepet sayfasına yönlendiriyoruz
        ->with('mesaj_tur', 'success')
            ->with('mesaj', 'Ürün Sepete Eklendi');
    }

    public function kaldir($rowid)
    {
        if(auth()->check())
        {
            $aktif_sepet_id=session('aktif_sepet_id');
            $cartItem=Cart::get($rowid);//Verilen bir rowıd ye ait olan sepet_urun değerini elde etmeyi sağlıyor,Bu şekilde sepetin o kaydındaki tüm bilgilere erişmiş oluyoruz
            SepetUrun::where('sepet_id',$aktif_sepet_id)->where('urun_id',$cartItem->id)->delete();

        }
        Cart::remove($rowid);
        return redirect()->route('sepet')
            ->with('mesaj_tur', 'success')
            ->with('mesaj', 'Ürün Sepetten Kaldırıldı');
    }


    public function bosalt()
    {
        if(auth()->check())
        {
            $aktif_sepet_id=session('aktif_sepet_id');
            SepetUrun::where('sepet_id',$aktif_sepet_id);

        }
        Cart::destroy();//sepetteki tüm ürünleri sepetten kaldırıryor
        return redirect()->route('sepet')
            ->with('mesaj_tur', 'success')
            ->with('mesaj', 'Sepetiniz Boşaltıldı');
    }

    public function guncelle($rowid)
    {
        //Validation işlemi
        $validator = Validator::make(request()->all(),
            [
                'adet' => 'required|numeric|between:0-5'
            ]);
        if ($validator->fails()) {
            session()->flash('mesaj_tur', 'success');
            session()->flash('mesaj', 'Adet Değeri 0 ile 5 arasında olmalıdır');
            return response()->json(['success' => false]);
        }
        //Güncellemelerin veritabanına yansıtılması
        if(auth()->check())
        {
            $aktif_sepet_id=session('aktif_sepet_id');
            $cartItem=Cart::get($rowid);//Verilen bir rowıd ye ait olan sepet_urun değerini elde etmeyi sağlıyor,Bu şekilde sepetin o kaydındaki tüm bilgilere erişmiş oluyoruz

            if(request('adet')==0)
            {
                SepetUrun::where('sepet_id',$aktif_sepet_id)->where('urun_id',$cartItem->id)->delete();
            }
            else
            {
                SepetUrun::where('sepet_id',$aktif_sepet_id)->where('urun_id',$cartItem->id)
                    ->update(['adet'=>request('adet')/*Burada requestden gelen adet değeriyle güncellemme yapılıyor*/]);
            }

        }
        //Sessionda güncellemelerin yansıtılması
        Cart::update($rowid, request('adet'));//app.js dosyasındaadn gelne adet değeri ile adet değeri güncelleniyor
        /*Güncelle Metodu Ajax ile çağırılan bir metod olduğu için redirect işlemi kullanılamıyor.Çünkü ajaxla çağırıldıktan sonra'success:function()' sadece bir dönüş değeri  döndürecektir
         yönlendirme işlemi çalışmayacaktır  */
        session()->flash('mesaj_tur', 'success');
        session()->flash('mesaj', 'Adet Bilginiz Güncelledi');
        return response()->json(['success' => true]);


    }


}
