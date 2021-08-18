<?php

namespace App\Http\Controllers;
use App\Models\Bukubesar;
use App\Models\Akun;
use Illuminate\Http\Request;

class BukubesarController extends Controller
{
    public function index()
    {
        // $bukubesar = Bukubesar::whereNotIn('saldo',[0])->get();

        // $groupBuku = $bukubesar->groupBy('id_akun');

        $akuns = Akun::where('id_user','=',auth()->user()->id)->orderBy('no_akun')->get();


        // for ($i=0; $i < ; $i++) { 
        //     // code...
        // }

        // $groupby = $bukubesar->groupBy('id_saldoawal');

        // $bukubesar = Bukubesar::whereNotIn('saldo',[0])->get();

        return view('admin.bukubesar.bukubesar',compact('akuns'));
    }

    public function akun(Request $request)
    {
        $cari = $request->cari;

        $akuns = Bukubesar::where('id_akun','=',$request->id_akun)->first();

        $akun_cari = Akun::where('id_user','=',auth()->user()->id)->orderBy('no_akun')->get();


        $bukubesar = Bukubesar::where('id_akun','=',$request->id_akun)->get();

        return view('admin.bukubesar.akunbb',compact('bukubesar','akuns','akun_cari'));
    }
}
