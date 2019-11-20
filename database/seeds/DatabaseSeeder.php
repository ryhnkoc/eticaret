<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UrunTableSeeder::class);
         $this->call(KategoriTableSeeder::class);
         $this->call(KullaniciSeeder::class);
    }
}
