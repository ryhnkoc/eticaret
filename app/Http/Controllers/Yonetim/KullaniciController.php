<?php


namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Kullanici;
use Illuminate\Support\Facades\Auth;

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
        $list = Kullanici::paginate(8);
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

    }
}
