<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabelBarangrusakDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangrusak_detail', function(Blueprint $table){
            $table->increments('id_barangrusak_detail');
            $table->integer('id_rusak')->unsigned();
            $table->bigInteger('kode_produk')->unsigned();
            $table->bigInteger('jumlah')->unsigned();
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
        Schema::drop('barangrusak_detail');
    }
}
