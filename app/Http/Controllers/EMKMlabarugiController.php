<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class EMKMlabarugiController extends Controller
{
    public function index()
    {
        $labarugi_pendapatan = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','like','81%')
                        ->where('no_akun','!=','81.03.00')
                        ->orderBy('no_akun','asc')
                        ->get();

        $potongan_penjualan = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','=','81.03.00')
                        ->get();

        $potongan_pembelian = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','=','91.13.00')
                        ->get();

        $labarugi_beban = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','like','91%')
                        ->where('no_akun','!=','91.13.00')
                        ->Where('no_akun','!=','91.15.06')
                        ->orderBy('no_akun','asc')
                        ->get();

        $pajaks = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','=','91.15.06')
                        ->get();


                        

        return view('admin.emkm.labarugi.labarugi',compact('labarugi_pendapatan','labarugi_beban','potongan_penjualan','potongan_pembelian','pajaks'));
    }
}
