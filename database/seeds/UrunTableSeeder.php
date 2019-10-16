<?php

use Illuminate\Database\Seeder;
use App\Urun;

class UrunTableSeeder extends Seeder
{
    public function run()
    {
        Urun::truncate();

        DB::table('urun')->insert(['urun_adi'=>'Bilgisayar','slug'=>'Bilgisayar','aciklama'=>'Bilgisayar Hakkında','fiyati'=>5]);
        DB::table('urun')->insert(['urun_adi'=>'TV','slug'=>'tv','aciklama'=>'TV Hakkında','fiyati'=>6]);
        DB::table('urun')->insert(['urun_adi'=>'Yazıcı','slug'=>'yazici','aciklama'=>'Yazıcı Hakkında','fiyati'=>3]);



    }
}
