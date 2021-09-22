<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buktipph22 extends Model
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
        'jenis_badan',
        'jenis_usaha',
        'harga',
        'tarif_lebih',
        'tarif',
        'pph_dipot',
        'tempat',
        'tanggal',
        'npwp_pemungut',
        'nama_pemungut'
    ];

    public function user(){ 
        return $this->belongsTo('App\Models\User','id_user');
    }
}
