<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pph4ayat2 extends Model
{
    use HasFactory;
    protected $pph4ayat2s = 'pph4ayat2s';
    protected $fillable = [
        'id',
        'id_user',
        'tahun_pajak',
        'npwp',
        'nama',
        'periode1',
        'periode2',

        'dpp_deposito',
        'tarif_deposito',
        'pph_deposito',

        'dpp_diskonto',
        'tarif_diskonto',
        'pph_diskonto',

        'dpp_bursaefek',
        'tarif_bursaefek',
        'pph_bursaefek',

        'dpp_ventura',
        'tarif_ventura',
        'pph_ventura',

        'dpp_bbm',
        'tarif_bbm',
        'pph_bbm',

        'dpp_haktanah',
        'tarif_haktanah',
        'pph_haktanah',

        'dpp_sewa',
        'tarif_sewa',
        'pph_sewa',

        'dpp_pelkonstruksi',
        'tarif_pelkonstruksi',
        'pph_pelkonstruksi',

        'dpp_perenkonstruksi',
        'tarif_perenkonstruksi',
        'pph_perenkonstruksi',

        'dpp_pengkonstruksi',
        'tarif_pengkonstruksi',
        'pph_pengkonstruksi',

        'dpp_dagang',
        'tarif_dagang',
        'pph_dagang',

        'dpp_penerbangan',
        'tarif_penerbangan',
        'pph_penerbangan',

        'dpp_pelayaran',
        'tarif_pelayaran',
        'pph_pelayaran',

        'dpp_aktiva',
        'tarif_aktiva',
        'pph_aktiva',

        'dpp_derivatif',
        'tarif_derivatif',
        'pph_derivatif',

        'dpp_peredaran',
        'tarif_peredaran',
        'pph_peredaran',

        'jumlah_jba',

    ];

    public function user(){ 
        return $this->belongsTo('App\Models\User','id_user');
    }

}
