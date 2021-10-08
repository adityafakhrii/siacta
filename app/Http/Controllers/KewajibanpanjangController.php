<?php

namespace App\Http\Controllers;
use App\Models\Kewajibanpanjang;
use App\Models\Akun;
use DB;
use Illuminate\Http\Request;

class KewajibanpanjangController extends Controller
{
    public function create()
    {
        $akuns = DB::table('akuns')
                    ->where('id_user','=',auth()->user()->id)
                    ->where('no_akun', 'like', '61%')
                    ->get(); 
        return view('admin.emkm.calk.tambahkewajibanpanjang',compact('akuns'));
    }

    public function store(Request $request)
    {
        $a = new Kewajibanpanjang;
        $a->id_user = auth()->user()->id;
        $a->id_akun = $request->id_akun;
        $a->keterangan = $request->keterangan;

        $a->save();

        return redirect('/calk')->with('success','Tambah kewajiban jangka panjang berhasil!');
    }
}
