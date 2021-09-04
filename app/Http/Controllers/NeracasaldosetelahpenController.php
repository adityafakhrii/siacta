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
                        ->orderBy('no_akun','asc')
                        ->get();              

        return view('admin.neracasaldosetelahpen.neracasaldosetelahpen',compact('neracasaldo'));
    }
}
