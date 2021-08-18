<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnalumum extends Model
{
    use HasFactory;
    protected $jurnalumums = 'jurnalumums';
    protected $fillable = ['id','id_transaksi','id_akun','keterangan','debit','kredit'];

    public function transaksi(){	
    	return $this->belongsTo('App\Models\Transaksi','id_transaksi');
    }

    public function akun(){	
    	return $this->belongsTo('App\Models\Akun','id_akun');
    }
}
