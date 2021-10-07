<?php

namespace App\Http\Controllers;
use App\Models\Neracasaldo;
use App\Models\Bukubesar;
use Auth;
use DB;
use Illuminate\Http\Request;

class NeracasaldoController extends Controller
{
    public function index()
    {
        $neracasaldo = DB::table('bukubesars')
                        ->join('akuns','bukubesars.id_akun','=','akuns.id')
                        ->where('id_user','=',auth()->user()->id)
                        ->where('bukubesars.saldo','!=',0)
                        ->whereRaw('bukubesars.id IN ( SELECT MAX(id) FROM bukubesars GROUP BY id_akun)')
                        ->orderBy('no_akun','asc')
                        ->get();


        // $total_debit =  DB::table('bukubesars')
        //                 ->selectRaw('SUM(CASE WHEN akuns.saldo_normal = \'debit\' THEN saldo ELSE 0 END) as TOTAL')
        //                 ->join('akuns','bukubesars.id_akun','=','akuns.id')
        //                 ->whereRaw('bukubesars.id IN (SELECT MAX(id) FROM bukubesars GROUP BY id_akun)')
        //                 ->get();

        // $total_kredit =  DB::table('bukubesars')
        //                 ->selectRaw('SUM(CASE WHEN akuns.saldo_normal = \'kredit\' THEN saldo ELSE 0 END) as TOTAL')
        //                 ->join('akuns','bukubesars.id_akun','=','akuns.id')
        //                 ->whereRaw('bukubesars.id IN (SELECT MAX(id) FROM bukubesars GROUP BY id_akun)')
        //                 ->get();                

        return view('admin.neracasaldo.neracasaldo',compact('neracasaldo'));

    }
}
