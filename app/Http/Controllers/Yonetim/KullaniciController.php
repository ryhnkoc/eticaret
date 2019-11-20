<?php


namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Kullanici;
use App\KullaniciDetay;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class KullaniciController extends Controller
{
    public function oturumac()
    {
        if (request()->isMethod('POST'))//gelen metod değerini öğrenmemizi sağlıyor
        {
            $this->validate(request(), [
                'email' => 'required|email',
                'sifre' => 'required'
            ]);

            $credentials = [
                'email' => request()->get('email'),
                'password' => request()->get('sifre'),
                'yonetici_mi' => true,
                'aktif_mi' => true
            ];
            if (\Auth::guard('yonetim')->attempt($credentials))//müşteri arayüzünde farklı yönetim arayüzünde farklı kullanıcılarla giriş yapmak için Auth::guard() kullanılıyorYani müşteri arayüzünde farklı olarak başka bir giriş işlemi yapacagımızı belirtiyoruz
            {
                return redirect()->route('yonetim.anasayfa');
            } else {
                return back()->withInput()->withErrors(['email' => 'Giriş Hatalı']);
            }
        }
        return view('yonetim.oturumac');//Views altındaki yönetim -> altındaki oturum ac dosyasına yönlendiriyoruz
    }

    public function oturumukapat()
    {
        Auth::guard('yonetim')->logout();
        request()->session()->flush();
        request()->session()->regenerate();
        return redirect()->route('yonetim.oturumac');

    }

    //Kullanici Yönetimi
    public function index()
    {
        if(request()->filled('aranan'))
        {
            request()->flash();//formdan gönderilen vrilerin session içinde saklanmasını sağlıyor
            $aranan=request('aranan');
            $list=Kullanici::where('adsoyad','like',"%$aranan%")
            ->orWhere('email','like',"%$aranan%")
            ->paginate(8)
            ->appends('aranan',$aranan);//arama işlemi yaparken aranan kayıt ilk sayfada gösteriliyor ancak diğer sayfalarda arama kaydı tutulmayıp arama işlem sonucu gözükmüyor bunu engellemek için yapıldı.

        }else {
            $list = Kullanici::paginate(8);
        }
        return view('yonetim.kullanici.index', compact('list'));

    }

    public function form($id=0)
    {
        $entry=new Kullanici;//eğr ıd değeri gelmezse bir kullanıcı olmayacağı ancak bunu form php ye göndereceğimiz için başta boş bir kullanıcıdan entry objesi oluşturuyoruz
        if($id>0)
        {
            $entry=Kullanici::find($id);
        }
        return view('yonetim.kullanici.form',compact('entry'));
    }

    public function kaydet($id=0)
    {//$id alanı 0 ise yeni bir kayıt oluşturulacak ancak $id alanı dolu ise güncelleme işlemi yapılacak demek
        $this->validate(request(),[
            'adsoyad'=>'required',
            'email'=>'required|email'
        ]);
        $data=request()->only('adsoyad','email');
        if(request()->filled('sifre'))
        {//sifre alanı doldurulmuşşsa bu işlem yapılır yani güncellenecekler arasına alınır ,$data bir dizidir.
            $data['sifre']=Hash::make(request('sifre'));
        }

        //bir alanın doldurulup doldurulmadıını chexboxlar için seçilip seçilmediğini kontrol ediyor.Checkboxlar secilmemişse boş dönüyor
        $data['aktif_mi']=request()->has('aktif_mi') && request('aktif_mi')=='true'? 'true':'false';
        $data['yonetici_mi']=request()->has('yonetici_mi') && request('yonetici_mi')=='true' ? 'true':'false';
        if($id>0)
        {
            $entry=Kullanici::where('id',$id)->firstorFail();
            $entry->update($data);

        }else
        {   $data=request();
            $entry=new Kullanici;
            $entry->adsoyad=request('adsoyad');
            $entry->yonetici_mi=$data->yonetici_mi;
            $entry->aktif_mi=$data->aktif_mi;
            $entry->email=$data->email;
            $entry->sifre=$data->sifre;
            $entry->save();
        }

        KullaniciDetay::updateOrCreate(
            [
                'kullanici_id'=>$entry->id
            ],
            [
                'adres'=>request('adres'),
                'telefon'=>request('telefon'),
                'cepTelefon'=>request('cepTelefon')


            ]
        );
        return redirect()
            ->route('yonetim.kullanici.duzenle',$entry->id)
            ->with('mesaj',($id>0 ? 'Güncellendi':'Kaydedildi'))
            ->with('mesaj_tur','success');

    }

    public function sil($id)
    {
        Kullanici::destroy($id);
        return redirect()
            ->route('yonetim.kullanici')
            ->with('mesaj','Kayıt Silindi')
            ->with('mesaj_tur','success');

    }
}
