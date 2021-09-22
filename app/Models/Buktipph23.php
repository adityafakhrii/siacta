<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buktipph23 extends Model
{
    use HasFactory;
    protected $buktipph22s = 'buktipph22s';
    protected $fillable = [
        'id',
        'id_user',
        'no_bukti',
        'npwp',
        'nama',
        'alamat',
        'jenis_penghasilan',
        'jenis_jasa',
        'jumlah_peng_bruto',
        'tarif_lebih',
        'tarif',
        'pph_dipot',
        'tempat',
        'tanggal',
        'npwp_pemotong',
        'nama_pemotong'
    ];

    public function user(){ 
        return $this->belongsTo('App\Models\User','id_user');
    }
}
