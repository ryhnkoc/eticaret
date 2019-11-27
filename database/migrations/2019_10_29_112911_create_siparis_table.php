<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiparisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siparis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('sepet_id')->unsigned();
            $table->decimal('siparis_tutari',15,4);
            $table->string('durum',30)->nullable();
            $table->string('banka',20);
            $table->integer('taksit_sayisi')->nullable();
            $table->unique('sepet_id');
            $table->foreign('sepet_id')->references('id')->on('sepet')->onDelete('cascade');


            $table->string('adsoyad',50)->nullable();
            $table->string('telefon',20)->nullable();
            $table->string('ceptelefon',20)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siparis');
    }
}
