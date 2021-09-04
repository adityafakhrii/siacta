<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akumulasi extends Model
{
    use HasFactory;
    protected $akumulasis = 'akumulasis';
    protected $fillable = ['id','id_user','nama_aset','nilai_aset','jumlah_unit','total_harga'];

    public function user(){ 
        return $this->belongsTo('App\Models\User','id_user');
    }
}
