<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uraianpph23 extends Model
{
    protected $uraianpph23s = 'uraianpph23s';
    protected $fillable = [
        'id',
        'id_user',
        'id_pph23',
        'uraian',
        'npwp_pph23',
        'kap_kjs',
        'jumlah_peng_bruto',
        'tl_pph23',
        't_pph23',
        'pph_dipot23'
    ];

    public function user(){ 
        return $this->belongsTo('App\Models\User','id_user');
    }

    public function pph23(){ 
        return $this->belongsTo('App\Models\Pph23','id_pph23');
    }
}
