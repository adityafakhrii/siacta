<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pph21 extends Model
{
    use HasFactory;
    protected $pph21s = 'pph21s';
    protected $fillable = [
        'id',
        'id_user',
        'form_pajak',
        'tahun_pajak',
        'nama_wajib',
        'npwp',
        'pekerjaan',
        'no_telepon',
        'sk_suami_istri',
        'npwp_suami_istri',
        'klu',
        'no_faks',
        'phneto_dn',
        'phneto_dn_lain',
        'phneto_ln',
        'jml_peng_neto',
        'zakat_sumbang',
        'total_peng_neto',
        'peng_tidak_pajak',
        'tk',
        'k',
        'ki',
        'peng_pajak',
        'pph_terutang',
        'pengem_pph24',
        'jml_pph_terutang',
        'pph_dipot_ln',
        'pph_dibayar',
        'pph_dipungut',
        'pph25',
        'stp_pph25',
        'jml_kredit_pajak',
        'pph29',
        'pph28a',
        'tgl_lunas',
        'permohonan',
        'angsuran_pph25',
        'status_ang_pph25',
        'pengisi_spt',
        'tgl_pernyataan',
        'nama_pem_kerja',
        'npwp_pem_kerja'
    ];

    public function user(){ 
        return $this->belongsTo('App\Models\User','id_user');
    }

    public function akun(){ 
        return $this->belongsTo('App\Models\Akun','id_akun');
    }

    public function lampiran(){ 
        return $this->hasMany('App\Models\Lampiran','id_pph21');
    }
}
