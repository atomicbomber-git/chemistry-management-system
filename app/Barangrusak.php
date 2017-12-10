<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barangrusak extends Model
{
    protected $table = 'barangrusak';
   	protected $primaryKey = 'id_rusak';

   	public function rusakDetails()
    {
    	return $this->hasMany("App\BarangrusakDetail", "id_rusak", "id_rusak");
    }
}
