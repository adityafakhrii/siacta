<?php

namespace App\Http\Controllers;
use DB;
use PDF;
use Illuminate\Http\Request;

class NeracasaldosetelahpenController extends Controller
{
    public function index()
    {
        $neracasaldo = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('id_user','=',auth()->user()->id)
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->orderBy('no_akun','asc')
                        ->get();              

        return view('admin.neracasaldosetelahpen.neracasaldosetelahpen',compact('neracasaldo'));
    }

    public function pdf()
    {
        $neracasaldo = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('id_user','=',auth()->user()->id)
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->orderBy('no_akun','asc')
                        ->get();

        return PDF::loadView('admin.neracasaldosetelahpen.exportneracasaldosetelahpen',compact('neracasaldo'))->stream('Neraca Saldo Setelah Disesuaikan - SIACTA.pdf');
    }
}
