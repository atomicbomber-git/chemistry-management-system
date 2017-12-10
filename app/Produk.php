<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    

    public function kategori(){
    	return $this->belongsTo('App\Kategori');
    }

     public function penerimaanDetails()
    {
    	return $this->hasMany("App\PenerimaanDetail", "kode_produk", "kode_produk");
    }
   
}

