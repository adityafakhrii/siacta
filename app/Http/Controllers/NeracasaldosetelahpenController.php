<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class NeracasaldosetelahpenController extends Controller
{
    public function index()
    {
        $neracasaldo = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->get();


        $total_debit =  DB::table('bukubesarpenyesuaians')
                        ->selectRaw('SUM(CASE WHEN akuns.saldo_normal = \'debit\' THEN saldo ELSE 0 END) as TOTAL')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->whereRaw('bukubesarpenyesuaians.id IN (SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->get();

        $total_kredit =  DB::table('bukubesarpenyesuaians')
                        ->selectRaw('SUM(CASE WHEN akuns.saldo_normal = \'kredit\' THEN saldo ELSE 0 END) as TOTAL')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->whereRaw('bukubesarpenyesuaians.id IN (SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->get();                

        return view('admin.neracasaldosetelahpen.neracasaldosetelahpen',compact('neracasaldo','total_debit','total_kredit'));
    }
}
