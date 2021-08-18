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
                        ->whereRaw('bukubesars.id IN ( SELECT MAX(id) FROM bukubesars GROUP BY id_akun)')
                        ->get();


        $total_debit =  DB::table('bukubesars')
                        ->selectRaw('SUM(CASE WHEN akuns.saldo_normal = \'debit\' THEN saldo ELSE 0 END) as TOTAL')
                        ->join('akuns','bukubesars.id_akun','=','akuns.id')
                        ->whereRaw('bukubesars.id IN (SELECT MAX(id) FROM bukubesars GROUP BY id_akun)')
                        ->get();

        $total_kredit =  DB::table('bukubesars')
                        ->selectRaw('SUM(CASE WHEN akuns.saldo_normal = \'kredit\' THEN saldo ELSE 0 END) as TOTAL')
                        ->join('akuns','bukubesars.id_akun','=','akuns.id')
                        ->whereRaw('bukubesars.id IN (SELECT MAX(id) FROM bukubesars GROUP BY id_akun)')
                        ->get();                

            // $total_debit = Bukubesar::whereHas('akun',function ($query){
            //     $query->where('saldo_normal','=','debit');
            // })->orWhere('id','=',Bukubesar::max('id'))->groupBy('id_akun')->sum('saldo');

                        // $total_debit = DB::table('bukubesars')
                        // ->select(DB::raw('SUM(CASE WHEN akuns.saldo_normal = \'debit\' THEN saldo ELSE 0 END)'),DB::raw('SUM(CASE WHEN akuns.saldo_normal = \'kredit\' THEN saldo ELSE 0 END)'))
                        // ->join('akuns','bukubesars.id_akun','=','akuns.id')
                        // ->get();

        return view('admin.neracasaldo.neracasaldo',compact('neracasaldo','total_debit','total_kredit'));
        // dd($total_debit[0]);

    }
}