<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabelDetailPenerimaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('detail_penerimaan', function(Blueprint $table){
            $table->increments('id_detail_penerimaan');
            $table->integer('id_penerimaan')->unsigned();
            $table->bigInteger('kode_produk')->unsigned();
            $table->integer('volume')->unsigned();
            $table->integer('jumlah')->unsigned();
            $table->integer('sub_total')->unsigned();
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
        Schema::drop('detail_penerimaan');
    }
}
