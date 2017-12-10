<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pemakaian extends Model
{
   	protected $table = 'pemakaian';
   	protected $primaryKey = 'id_pemakaian';

   	public function pemakaianDetails()
    {
    	return $this->hasMany("App\PemakaianDetail", "id_pemakaian", "id_pemakaian");
    }
}
