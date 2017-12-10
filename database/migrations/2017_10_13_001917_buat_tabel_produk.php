<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuatTabelProduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function(Blueprint $table){
            $table->increments('id_produk');
            $table->integer('id_kategori')->unsigned();
            $table->string('nama_produk');
            $table->date('tgl_kadaluarsa');
            $table->string('sifat');
            $table->string('ket');
            $table->bigInteger('harga_jual');
            $table->string('foto', 100)->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('produk');
    }
}
