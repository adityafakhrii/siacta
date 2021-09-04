<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnalpenutup extends Model
{
    use HasFactory;
    protected $jurnalpenutups = 'jurnalpenutups';
    protected $fillable = ['id','id_bubespen','id_akun','keterangan','debit','kredit'];

    public function bukubesarpen(){    
        return $this->belongsTo('App\Models\Bukubesarpenyesuaian','id_bubespen');
    }

    public function akun(){ 
        return $this->belongsTo('App\Models\Akun','id_akun');
    }

    public function user(){ 
        return $this->belongsTo('App\Models\User','id_user');
    }
}
