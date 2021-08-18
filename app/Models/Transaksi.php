<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $transaksis = 'transaksis';
    protected $fillable = [
    	'id',
    	'id_akun',
        'id_user',
    	'dok_bukti',
    	'jenis_pembayaran',
    	'keterangan',
    	'tgl',
    	'nominal',
    	'nominal_dp',
        'nominal_ppn',
        'nominal_pph22',
    	'nominal_pph23',
    	'potongan_pembelian',
    	'potongan_penjualan',
    	'umur_ekonomis',
    	'nilai_sisa',
    	'beban_penyusutan',
    	'status'
    ];

    public function akun(){	
    	return $this->belongsTo('App\Models\Akun','id_akun');
    }

    public function jurnalumum(){	
    	return $this->hasMany('App\Models\Jurnalumum','id_transaksi');
    }

}
