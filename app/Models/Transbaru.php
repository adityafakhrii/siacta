<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transbaru extends Model
{
    use HasFactory;
    protected $transaksis = 'transbarus';
    protected $fillable = [
        'id',
        'id_akun',
        'id_user',
        'keterangan',
        'nominal',
        'status'
    ];

    public function akun(){ 
        return $this->belongsTo('App\Models\Akun','id_akun');
    }

    public function user(){   
        return $this->belongsTo('App\Models\User','id_user');
    }

    public function jurnalpenyesuaian(){   
        return $this->hasMany('App\Models\Jurnalpenyesuaian','id_transbaru');
    }
}
