<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bukubesar extends Model
{
    use HasFactory;
    protected $bukubesars = 'bukubesars';
    protected $fillable = ['id','id_akun','debit','kredit','keterangan'];

    public function akun(){    
        return $this->belongsTo('App\Models\Akun','id_akun');
    }
}
