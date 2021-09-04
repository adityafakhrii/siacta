<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasbank extends Model
{
    use HasFactory;
    protected $kasbanks = 'kasbanks';
    protected $fillable = ['id','id_user','id_akun','keterangan'];

    public function user(){ 
        return $this->belongsTo('App\Models\User','id_user');
    }

    public function akun(){ 
        return $this->belongsTo('App\Models\Akun','id_akun');
    }
}
