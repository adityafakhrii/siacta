<?php

namespace App\Http\Controllers;
use App\Models\Kewajibanlain;
use App\Models\Akun;
use DB;
use Illuminate\Http\Request;

class KewajibanlainController extends Controller
{
    public function create()
    {
        $akuns = DB::table('akuns')
                    ->where('id_user','=',auth()->user()->id)
                    ->where('no_akun', 'like', '62%')
                    ->get(); 
        return view('admin.emkm.calk.tambahkewajibanlain',compact('akuns'));
    }

    public function store(Request $request)
    {
        $a = new Kewajibanlain;
        $a->id_user = auth()->user()->id;
        $a->id_akun = $request->id_akun;
        $a->keterangan = $request->keterangan;

        $a->save();

        return redirect('/emkm/calk')->with('success','Tambah kewajiban lain-lain berhasil!');
    }
}
