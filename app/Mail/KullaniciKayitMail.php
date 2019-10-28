<?php

namespace App\Mail;

use App\Kullanici;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KullaniciKayitMail extends Mailable
{
    use Queueable, SerializesModels;
    public $kullanici;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Kullanici $kullanici)
    {
        $this->kullanici=$kullanici;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {//Mail ile ilgili ayarlamaları yapıyoruz
        return $this
            ->from('reyhankoc94@gmail.com')
            ->subject(config('app.name'). 'Kullanıcı Kaydı')
            ->view('emails.kullanici_kayit');//view gönderilecek mailin içeriğini ayarlamak için kullanılmakta
    }
}
