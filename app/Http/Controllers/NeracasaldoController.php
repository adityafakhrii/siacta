<?php

namespace App\Http\Controllers;
use App\Models\Neracasaldo;
use App\Models\Bukubesar;
use Auth;
use DB;
use PDF;
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

        return view('admin.neracasaldo.neracasaldo',compact('neracasaldo'));

    }

    public function pdf()
    {
        $neracasaldo = DB::table('bukubesars')
                        ->join('akuns','bukubesars.id_akun','=','akuns.id')
                        ->where('id_user','=',auth()->user()->id)
                        ->where('bukubesars.saldo','!=',0)
                        ->whereRaw('bukubesars.id IN ( SELECT MAX(id) FROM bukubesars GROUP BY id_akun)')
                        ->orderBy('no_akun','asc')
                        ->get();

        // $pdf = ;

        return PDF::loadView('admin.neracasaldo.exportneracasaldo',compact('neracasaldo'))->stream('Neraca Saldo Sebelum Penyesuaian - SIACTA.pdf');
    }
}
