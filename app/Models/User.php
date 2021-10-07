<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'status_neracaawal',
        'status_calk'
    ];

    public function unitusaha(){ 
        return $this->belongsTo('App\Models\Unitusaha','id_unitusaha');
    }

    public function akun(){ 
        return $this->hasMany('App\Models\Akun','id_user');
    }

    public function anggota(){ 
        return $this->hasMany('App\Models\Anggota','id_user');
    }

    public function neracasaldoawal(){ 
        return $this->hasMany('App\Models\Neracasaldoawal','id_user');
    }

    public function transbaru(){ 
        return $this->hasMany('App\Models\Transbaru','id_user');
    }

    public function jurnalpenutup(){ 
        return $this->hasMany('App\Models\Jurnalpenutup','id_user');
    }

    public function aset(){ 
        return $this->hasMany('App\Models\Aset','id_user');
    }

    public function akumulasi(){ 
        return $this->hasMany('App\Models\Akumulasi','id_user');
    }

    public function piutangusaha(){ 
        return $this->hasMany('App\Models\Piutangusaha','id_user');
    }

    public function kasbank(){ 
        return $this->hasMany('App\Models\Kasbank','id_user');
    }

    public function investasipendek(){ 
        return $this->hasMany('App\Models\Investasipendek','id_user');
    }

    public function piutangnon(){ 
        return $this->hasMany('App\Models\Piutangnon','id_user');
    }

    public function perlengkapan(){ 
        return $this->hasMany('App\Models\Perlengkapan','id_user');
    }

    public function pembayaranmuka(){ 
        return $this->hasMany('App\Models\Pembayaranmuka','id_user');
    }

    public function asetlain(){ 
        return $this->hasMany('App\Models\Asetlain','id_user');
    }

    public function investasipanjang(){ 
        return $this->hasMany('App\Models\Investasipanjang','id_user');
    }

    public function asettetap(){ 
        return $this->hasMany('App\Models\Asettetap','id_user');
    }

    public function asetleasing(){ 
        return $this->hasMany('App\Models\Asetleasing','id_user');
    }

    public function properti(){ 
        return $this->hasMany('App\Models\Properti','id_user');
    }

    public function asettidakberwujud(){ 
        return $this->hasMany('App\Models\Asettidakberwujud','id_user');
    }

    public function kewajibanpendeks(){ 
        return $this->hasMany('App\Models\Kewajibanpendeks','id_user');
    }

    public function kewajibanpanjang(){ 
        return $this->hasMany('App\Models\Kewajibanpanjang','id_user');
    }

    public function kewajibanlain(){ 
        return $this->hasMany('App\Models\Kewajibanlain','id_user');
    }

    public function ekuitas(){ 
        return $this->hasMany('App\Models\Ekuitas','id_user');
    }

    public function calk(){ 
        return $this->hasMany('App\Models\Calk','id_user');
    }

    public function pph21(){ 
        return $this->hasMany('App\Models\Pph21','id_user');
    }

    public function lampiran(){ 
        return $this->hasMany('App\Models\Lampiran','id_user');
    }

    public function buktipph21tidaktetap(){ 
        return $this->hasMany('App\Models\Buktipph21tidaktetap','id_user');
    }

    public function buktipph21tetap(){ 
        return $this->hasMany('App\Models\Buktipph21tetap','id_user');
    }

    public function buktipph22(){ 
        return $this->hasMany('App\Models\Buktipph22','id_user');
    }

    public function pph22(){ 
        return $this->hasMany('App\Models\Pph22','id_user');
    }

    public function lampiranpph22(){ 
        return $this->hasMany('App\Models\Lampiranpph22','id_user');
    }

    public function pph4ayat2(){ 
        return $this->hasMany('App\Models\Pph4ayat2','id_user');
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
