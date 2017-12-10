<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class penerimaan extends Model
{
    protected $table = 'penerimaan';
    protected $primaryKey = 'id_penerimaan';

    public function penerimaanDetails()
    {
    	return $this->hasMany("App\PenerimaanDetail", "id_penerimaan", "id_penerimaan");
    }

    
}
