<?php

namespace App\Http\Controllers;
use App\Models\Piutangnon;
use App\Models\Akun;
use DB;
use Illuminate\Http\Request;

class PiutangnonController extends Controller
{
    public function create()
    {
        $akuns = DB::table('akuns')
                    ->where('id_user','=',auth()->user()->id)
                    ->where('no_akun', 'like', '14%')
                    ->get(); 
        return view('admin.emkm.calk.tambahpiutangnon',compact('akuns'));
    }

    public function store(Request $request)
    {
        $a = new Piutangnon;
        $a->id_user = auth()->user()->id;
        $a->id_akun = $request->id_akun;
        $a->keterangan = $request->keterangan;

        $a->save();

        return redirect('/emkm/calk')->with('success','Tambah piutang non usaha berhasil!');
    }
}
