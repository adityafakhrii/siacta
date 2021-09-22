<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buktipph21tetap extends Model
{
    use HasFactory;
    protected $buktipph21tetaps = 'buktipph21tetaps';
    protected $fillable = [
        'id',
        'id_user',
        'no_form',
        'nomor',
        'npwp_pemotong',
        'nama_pemotong',
        'npwp',
        'nik_paspor',
        'nama',
        'alamat',
        'jenis_kelamin',
        'k',
        'tk',
        'hb',
        'jabatan',
        'kar_asing',
        'kode_negara',
        'kode_objek',
        'gaji_pensiun',
        'tunjangan_pph',
        'tunjangan_lain',
        'honorarium',
        'premi_asuransi',
        'natura',
        'tantiem',
        'jumlah_peng_bruto',
        'biaya_jabatan',
        'iuran_pensiun',
        'jumlah_pengurangan',
        'jumlah_peng_neto',
        'ptkp',
        'persen_pajak',
        'pkp',
        'pph21_pkp',
        'pph21_dipotong',
        'pph21_terutang',
        'pph21_pph26',
        'npwp_id_pemotong',
        'nama_id_pemotong',
        'tgl_pemotong',
    ];

    public function user(){ 
        return $this->belongsTo('App\Models\User','id_user');
    }
}
