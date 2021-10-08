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
                        ->where('id_user','=',auth()->user()->id)
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','like','8%')
                        ->where(function($query){
                            $query->where('no_akun','!=','81.06.00');
                            $query->orWhere('no_akun','!=','81.07.00');
                            $query->orWhere('no_akun','!=','81.05.00');
                        })
                        ->orderBy('no_akun','asc')
                        ->get();

        $labarugi_beban = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('id_user','=',auth()->user()->id)
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','like','9%')
                        ->Where(function($query){
                            $query->where('no_akun','!=','91.01.02');
                            $query->orWhere('no_akun','!=','91.01.03');
                            $query->orWhere('no_akun','!=','91.01.04');
                        })
                        ->orderBy('no_akun','asc')
                        ->get();

        $pajaks = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('id_user','=',auth()->user()->id)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','=','92.14.00')
                        ->get();
                      

        return view('admin.emkm.labarugi.labarugi',compact('labarugi_pendapatan','labarugi_beban','pajaks'));
    }
}