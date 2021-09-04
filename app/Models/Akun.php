<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    use HasFactory;
    protected $akuns = 'akuns';
    protected $fillable = ['id','id_user','no_akun','nama_akun','saldo_normal','status'];

    public function neracasaldoawal(){	
    	return $this->hasMany('App\Models\Neracasaldoawal','id_akun');
    }

    public function user(){	
    	return $this->belongsTo('App\Models\User','id_user');
    }

    public function jurnalumum(){	
    	return $this->hasMany('App\Models\Jurnalumum','id_akun');
    }

    public function bukubesar(){  
        return $this->hasMany('App\Models\Bukubesar','id_akun');
    }

    public function bukubesarpenyesuaian(){  
        return $this->hasMany('App\Models\Bukubesar','id_akun');
    }

    public function jurnalpenyesuaian(){   
        return $this->hasMany('App\Models\Jurnalpenyesuaian','id_akun');
    }

    public function jurnalpenutup(){   
        return $this->hasMany('App\Models\Jurnalpenutup','id_akun');
    }

    public function piutangusaha(){   
        return $this->hasMany('App\Models\Piutangusaha','id_akun');
    }

    public function kasbank(){   
        return $this->hasMany('App\Models\Kasbank','id_akun');
    }

    public function investasipendek(){   
        return $this->hasMany('App\Models\Investasipendek','id_akun');
    }

    public function piutangnon(){   
        return $this->hasMany('App\Models\Piutangnon','id_akun');
    }

    public function perlengkapan(){   
        return $this->hasMany('App\Models\Perlengkapan','id_akun');
    }

    public function pembayaranmuka(){   
        return $this->hasMany('App\Models\Pembayaranmuka','id_akun');
    }

    public function asetlain(){   
        return $this->hasMany('App\Models\Asetlain','id_akun');
    }

    public function investasipanjang(){   
        return $this->hasMany('App\Models\Investasipanjang','id_akun');
    }

    public function asettetap(){   
        return $this->hasMany('App\Models\Asettetap','id_akun');
    }

    public function asetleasing(){   
        return $this->hasMany('App\Models\Asetleasing','id_akun');
    }

}
