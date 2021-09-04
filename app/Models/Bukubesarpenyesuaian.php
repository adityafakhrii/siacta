<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bukubesarpenyesuaian extends Model
{
    use HasFactory;
    protected $bukubesarpenyesuaians = 'bukubesarpenyesuaians';
    protected $fillable = ['id','id_akun','debit','kredit'];

    public function akun(){    
        return $this->belongsTo('App\Models\Akun','id_akun');
    }

    public function jurnalpenutup(){    
        return $this->hasMany('App\Models\Jurnalpenutup','id_bubespen');
    }
}