<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pph23 extends Model
{
    use HasFactory;
    protected $pph23s = 'pph23s';
    protected $fillable = [
        'id',
        'id_user',
        'masa_pajak',
        'npwp',
        'nama',
        'alamat',
        'pengisi_spt',
        'nama_pengisi',
        'npwp_pengisi',
        'tanggal'
    ];

    public function user(){ 
        return $this->belongsTo('App\Models\User','id_user');
    }

    public function uraianpph23(){ 
        return $this->hasMany('App\Models\Uraianpph23','id_pph23');
    }

    public function lampiranpph23(){ 
        return $this->hasMany('App\Models\Lampiranpph23','id_pph23');
    }
}
