<?php

namespace App\Http\Controllers;
use App\Models\Asetlain;
use App\Models\Akun;
use DB;
use Illuminate\Http\Request;

class AsetlainController extends Controller
{
    public function create()
    {
        $akuns = DB::table('akuns')
                    ->where('id_user','=',auth()->user()->id)
                    ->where('no_akun', 'like', '18%')
                    ->get(); 
        return view('admin.emkm.calk.tambahasetlain',compact('akuns'));
    }

    public function store(Request $request)
    {
        $a = new Asetlain;
        $a->id_user = auth()->user()->id;
        $a->id_akun = $request->id_akun;
        $a->keterangan = $request->keterangan;

        $a->save();

        return redirect('/calk')->with('success','Tambah aset lainnya berhasil!');
    }
}
