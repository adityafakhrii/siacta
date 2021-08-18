<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnalpenyesuaian extends Model
{
    use HasFactory;
    protected $jurnalpenyesuaians = 'jurnalpenyesuaians';
    protected $fillable = ['id','id_transbaru','id_akun','keterangan','debit','kredit'];

    public function transbaru(){    
        return $this->belongsTo('App\Models\Transbaru','id_transbaru');
    }

    public function akun(){ 
        return $this->belongsTo('App\Models\Akun','id_akun');
    }
}
