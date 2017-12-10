<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePemakaianDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemakaian_detail', function(Blueprint $table){
            $table->increments('id_pemakaian_detail');
            $table->integer('id_pemakaian')->unsigned();
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
        Schema::drop('pemakaian_detail');
    }
}
