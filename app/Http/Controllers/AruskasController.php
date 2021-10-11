<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class AruskasController extends Controller
{
    public function index()
    {  
        $operasional = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('id_user','=',auth()->user()->id)
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where(function($query){
                            $query->where('no_akun','like','13%');
                            $query->orWhere('no_akun','like','81%');
                        })
                        ->orderBy('no_akun','asc')
                        ->get(); 

        $beban = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('id_user','=',auth()->user()->id)
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where(function($query){
                            $query->where('no_akun','like','92%');
                            $query->orWhere('no_akun','like','92%');
                            $query->orWhere('no_akun','like','93%');
                            $query->orWhere('no_akun','like','94%');
                            $query->orWhere('no_akun','like','95%');
                            $query->orWhere('no_akun','like','96%');
                            $query->orWhere('no_akun','like','97%');
                            $query->orWhere('no_akun','like','98%');
                            $query->orWhere('no_akun','like','15%');
                            $query->orWhere('no_akun','=','50.01.00');
                            $query->orWhere('no_akun','=','50.02.00');
                            $query->orWhere('no_akun','=','50.03.00');
                            $query->orWhere('no_akun','=','50.04.00');
                            $query->orWhere('no_akun','=','50.07.00');
                            $query->orWhere('no_akun','=','50.08.00');
                            $query->orWhere('no_akun','=','50.09.00');
                            $query->orWhere('no_akun','=','50.10.00');
                            $query->orWhere('no_akun','=','50.11.00');
                            $query->orWhere('no_akun','=','50.12.00');
                            $query->orWhere('no_akun','=','50.13.00');
                            $query->orWhere('no_akun','=','50.14.00');
                            $query->orWhere('no_akun','=','50.15.00');
                            $query->orWhere('no_akun','=','50.16.00');
                            $query->orWhere('no_akun','=','50.17.00');
                            $query->orWhere('no_akun','=','50.18.00');
                            $query->orWhere('no_akun','=','50.19.00');
                            $query->orWhere('no_akun','=','50.20.00');
                            $query->orWhere('no_akun','=','50.21.00');
                        })
                        ->orderBy('no_akun','asc')
                        ->get();



        $investtambah = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('id_user','=',auth()->user()->id)
                        ->where('saldo','!=',0)
                        ->whereNull('debit')
                        ->where(function($query){
                            $query->Where('no_akun','like','3%');
                            $query->orWhere('no_akun','like','42%');
                        })
                        ->orderBy('no_akun','asc')
                        ->get();

        $investtambah2 = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('id_user','=',auth()->user()->id)
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where(function($query){
                            $query->where('no_akun','like','82%');
                            $query->orWhere('no_akun','like','12%');
                            $query->orWhere('no_akun','like','21%');
                        })
                        ->orderBy('no_akun','asc')
                        ->get(); 

        $investkurang = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('id_user','=',auth()->user()->id)
                        ->where('saldo','!=',0)
                        ->whereNull('kredit')
                        ->where(function($query){
                            $query->where('no_akun','like','3%');
                            $query->orWhere('no_akun','like','42%');
                        })
                        ->orderBy('no_akun','asc')
                        ->get();

        $investkurang2 = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('id_user','=',auth()->user()->id)
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','=','16.03.00')
                        ->orderBy('no_akun','asc')
                        ->get();

                      

        return view('admin.etap.aruskas.aruskas',compact('operasional','beban','investtambah','investkurang','investtambah2','investkurang2'));
    }
}
