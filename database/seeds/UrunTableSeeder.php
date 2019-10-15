<?php

use Illuminate\Database\Seeder;

class UrunTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("uruns")->insert([
            'urun_adi'=>'mandalina',
            'fiyati'=>3.5

        ]);
    }
}
