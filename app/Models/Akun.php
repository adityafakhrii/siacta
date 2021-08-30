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
        return $this->hasMany('App\Models\jurnalpenyesuaian','id_akun');
    }

}
