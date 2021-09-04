<?php

namespace App\Http\Controllers;
use App\Models\Kasbank;
use App\Models\Akun;
use DB;
use Illuminate\Http\Request;

class KasbankController extends Controller
{
    public function create()
    {
        $akuns = DB::table('akuns')
                    ->where('id_user','=',auth()->user()->id)
                    ->where('no_akun', 'like', '11%')
                    ->get(); 
        return view('admin.emkm.calk.tambahkasbank',compact('akuns'));
    }

    public function store(Request $request)
    {
        $a = new Kasbank;
        $a->id_user = auth()->user()->id;
        $a->id_akun = $request->id_akun;
        $a->keterangan = $request->keterangan;

        $a->save();

        return redirect('/emkm/calk')->with('success','Tambah kas berhasil!');
    }
}
