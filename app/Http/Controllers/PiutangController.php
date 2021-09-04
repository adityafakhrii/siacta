<?php

namespace App\Http\Controllers;
use App\Models\Piutangusaha;
use App\Models\Akun;
use DB;
use Illuminate\Http\Request;

class PiutangController extends Controller
{
    public function create()
    {
        $akuns = DB::table('akuns')
                    ->where('id_user','=',auth()->user()->id)
                    ->where('no_akun', 'like', '13.02%')
                    ->where('no_akun', '!=', '13.02.00')
                    ->get(); 
        return view('admin.emkm.calk.tambahpiutang',compact('akuns'));
    }

    public function store(Request $request)
    {
        $a = new Piutangusaha;
        $a->id_user = auth()->user()->id;
        $a->id_akun = $request->id_akun;
        $a->saldo = $request->saldo;

        $a->save();

        return redirect('/emkm/calk')->with('success','Tambah piutang usaha berhasil!');
    }
}
