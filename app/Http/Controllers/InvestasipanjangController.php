<?php

namespace App\Http\Controllers;
use App\Models\Investasipanjang;
use App\Models\Akun;
use DB;
use Illuminate\Http\Request;

class InvestasipanjangController extends Controller
{
    public function create()
    {
        $akuns = DB::table('akuns')
                    ->where('id_user','=',auth()->user()->id)
                    ->where('no_akun', 'like', '21%')
                    ->get(); 
        return view('admin.emkm.calk.tambahinvestasipanjang',compact('akuns'));
    }

    public function store(Request $request)
    {
        $a = new Investasipanjang;
        $a->id_user = auth()->user()->id;
        $a->id_akun = $request->id_akun;
        $a->keterangan = $request->keterangan;

        $a->save();

        return redirect('/emkm/calk')->with('success','Tambah investasi panjang berhasil!');
    }
}
