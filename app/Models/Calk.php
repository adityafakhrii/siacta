<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calk extends Model
{
    use HasFactory;
    protected $calks = 'calks';
    protected $fillable = ['id','id_user','umum','pernyataan_kepatuhan','dasar_penyusunan','akum_penyusutan','pendapatan_beban','piutang_usaha','piutang_desa','piutang_lainnya','rk_pusat','aset_tetap_penyelesaian'];

    public function user(){ 
        return $this->belongsTo('App\Models\User','id_user');
    }

}

