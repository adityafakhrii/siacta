<?php

namespace App\Http\Controllers;
use App\Models\Ekuitas;
use App\Models\Akun;
use DB;
use Illuminate\Http\Request;

class EkuitasController extends Controller
{
    public function create()
    {
        $akuns = DB::table('akuns')
                    ->where('id_user','=',auth()->user()->id)
                    ->where('no_akun', 'like', '70%')
                    ->get(); 
        return view('admin.emkm.calk.tambahekuitas',compact('akuns'));
    }

    public function store(Request $request)
    {
        $a = new Ekuitas;
        $a->id_user = auth()->user()->id;
        $a->id_akun = $request->id_akun;
        $a->keterangan = $request->keterangan;

        $a->save();

        return redirect('/emkm/calk')->with('success','Tambah ekuitas berhasil!');
    }
}
