<?php

namespace App\Http\Controllers;
use App\Models\Bukubesar;
use App\Models\Akun;
use Illuminate\Http\Request;

class BukubesarController extends Controller
{
    public function index()
    {

        $akuns = Akun::where('id_user','=',auth()->user()->id)->orderBy('no_akun')->get();

        return view('admin.bukubesar.bukubesar',compact('akuns'));
    }

    public function akun(Request $request)
    {
        $cari = $request->cari;

        $akuns = Bukubesar::where('id_akun','=',$request->id_akun)->first();

        $akun_cari = Akun::where('id_user','=',auth()->user()->id)->orderBy('no_akun')->get();

        $bukubesar = Bukubesar::where('id_akun','=',$request->id_akun)->where('saldo','!=',0)->get();

        return view('admin.bukubesar.akunbb',compact('bukubesar','akuns','akun_cari'));
    }
}
