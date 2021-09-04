<?php

namespace App\Http\Controllers;
use App\Models\Asettetap;
use App\Models\Akun;
use DB;
use Illuminate\Http\Request;

class AsettetapController extends Controller
{
    public function create()
    {
        $akuns = DB::table('akuns')
                    ->where('id_user','=',auth()->user()->id)
                    ->where('no_akun', 'like', '31%')
                    ->get(); 
        return view('admin.emkm.calk.tambahasettetap',compact('akuns'));
    }

    public function store(Request $request)
    {
        $a = new Asettetap;
        $a->id_user = auth()->user()->id;
        $a->id_akun = $request->id_akun;
        $a->keterangan = $request->keterangan;

        $a->save();

        return redirect('/emkm/calk')->with('success','Tambah aset tetap berhasil!');
    }
}
