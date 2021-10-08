<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class PerubahanekuitasController extends Controller
{
    public function index()
    {  
        $modal_awal = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('id_user','=',auth()->user()->id)
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','=','70.13.00')
                        ->orderBy('no_akun','asc')
                        ->get();

        $tambahan_modal = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('id_user','=',auth()->user()->id)
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where(function($query){
                            $query->where('no_akun','=','70.01.00');
                            $query->orWhere('no_akun','==','70.02.00');
                            $query->orWhere('no_akun','==','70.03.00');
                        })
                        ->orderBy('no_akun','asc')
                        ->get();


        $prive = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('id_user','=',auth()->user()->id)
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','=','70.16.00')
                        ->orderBy('no_akun','asc')
                        ->get();



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

        $total_pendapatan = 0;
        foreach ($labarugi_pendapatan as $lr) {
            $total_pendapatan += $lr->saldo;
        }

        $total_beban = 0;
        foreach($labarugi_beban as $lb) {
            $total_beban += $lb->saldo;
        }

        $total_semua = $total_pendapatan - $total_beban;

        if ($total_semua > 0) {
          $pajak = $total_semua * (0.5/100);
        }else{
          $pajak = 0;
        }

        $total_labarugi = $total_semua - $pajak;
                      

        return view('admin.etap.ekuitas.ekuitas',compact('modal_awal','tambahan_modal','total_labarugi','prive'));
    }
}
