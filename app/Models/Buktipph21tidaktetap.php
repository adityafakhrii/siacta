<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buktipph21tidaktetap extends Model
{
    use HasFactory;
    protected $buktipph21tidaktetaps = 'buktipph21tidaktetaps';
    protected $fillable = [
        'id',
        'id_user',
        'no_form',
        'nomor',
        'npwp',
        'nik_paspor',
        'nama',
        'alamat',
        'wajib_ln',
        'kode_negara',
        'kode_objek',
        'jumlah_peng_bruto',
        'dasar_pajak',
        'tarif_lebih',
        'tarif',
        'pph_dipotong',
        'npwp_pemotong',
        'nama_pemotong',
        'tgl_potong',
    ];

    public function user(){ 
        return $this->belongsTo('App\Models\User','id_user');
    }
}
