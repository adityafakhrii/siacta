<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pph22 extends Model
{
    use HasFactory;
    protected $pph22s = 'pph22s';
    protected $fillable = [
        'id',
        'id_user',
        'masa_pajak',
        'npwp',
        'nama',
        'alamat',

        'kap_badan_usaha',
        'nop_badan_usaha',
        'pph_badan_usaha',
        'npwp_badan_usaha',
        'tl_badan_usaha',
        't_badan_usaha',

        'kap_penj_barang',
        'nop_penj_barang',
        'pph_penj_barang',
        'npwp_penj_barang',
        'tl_penj_barang',
        't_penj_barang',

        'kap_pembelian_bend',
        'nop_pembelian_bend',
        'pph_pembelian_bend',
        'npwp_pembelian_bend',
        'tl_pembelian_bend',
        't_pembelian_bend',

        'kap_api',
        'nop_api',
        'pph_api',
        'npwp_api',
        'tl_api',
        't_api',

        'kap_non_api',
        'nop_non_api',
        'pph_non_api',
        'npwp_non_api',
        'tl_non_api',
        't_non_api',

        'kap_hasil_lelang',
        'nop_hasil_lelang',
        'pph_hasil_lelang',
        'npwp_hasil_lelang',
        'tl_hasil_lelang',
        't_hasil_lelang',
        
        'kap_spbu',
        'nop_spbu',
        'pph_spbu',
        'npwp_spbu',
        'tl_spbu',
        't_spbu',

        'kap_pihak_lain',
        'nop_pihak_lain',
        'pph_pihak_lain',
        'npwp_pihak_lain',
        'tl_pihak_lain',
        't_pihak_lain',

        'kap_bumn',
        'nop_bumn',
        'pph_bumn',
        'npwp_bumn',
        'tl_bumn',
        't_bumn',

        'kap_penj_hasil',
        'nop_penj_hasil',
        'pph_penj_hasil',
        'npwp_penj_hasil',
        'tl_penj_hasil',
        't_penj_hasil',

        'kap_penj_ken',
        'nop_penj_ken',
        'pph_penj_ken',
        'npwp_penj_ken',
        'tl_penj_ken',
        't_penj_ken',

        'kap_pemb_batu',
        'nop_pemb_batu',
        'pph_pemb_batu',
        'npwp_pemb_batu',
        'tl_pemb_batu',
        't_pemb_batu',

        'kap_penj_emas',
        'nop_penj_emas',
        'pph_penj_emas',
        'npwp_penj_emas',
        'tl_penj_emas',
        't_penj_emas',

        'jumlah_nop',
        'jumlah_pph',

        'pengisi_spt',
        'nama_pengisi',
        'npwp_pengisi',
        'tanggal'
    ];

    public function user(){ 
        return $this->belongsTo('App\Models\User','id_user');
    }

    public function lampiranpph22(){ 
        return $this->hasMany('App\Models\Lampiranpph22','id_pph22');
    }
}
