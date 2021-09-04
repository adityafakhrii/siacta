<?php

namespace App\Http\Controllers;
use App\Models\Asettidakberwujud;
use App\Models\Akun;
use DB;
use Illuminate\Http\Request;

class AsettidakberwujudController extends Controller
{
    public function create()
    {
        $akuns = DB::table('akuns')
                    ->where('id_user','=',auth()->user()->id)
                    ->where('no_akun', 'like', '42%')
                    ->get(); 
        return view('admin.emkm.calk.tambahasettidakberwujud',compact('akuns'));
    }

    public function store(Request $request)
    {
        $a = new Asettidakberwujud;
        $a->id_user = auth()->user()->id;
        $a->id_akun = $request->id_akun;
        $a->keterangan = $request->keterangan;

        $a->save();

        return redirect('/emkm/calk')->with('success','Tambah aset tidak berwujud berhasil!');
    }
}
