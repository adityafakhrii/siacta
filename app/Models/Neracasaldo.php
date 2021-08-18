<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Neracasaldo extends Model
{
    use HasFactory;
    protected $neracasaldos = 'neracasaldos';
    protected $fillable = ['id','id_akun','id_user','debit','kredit'];

    public function akun(){ 
        return $this->belongsTo('App\Models\Akun','id_akun');
    }

    public function user(){ 
        return $this->belongsTo('App\Models\User','id_user');
    }
}
