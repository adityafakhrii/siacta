<?php

namespace App\Http\Controllers;
use App\Models\Akumulasi;
use Illuminate\Http\Request;

class AkumulasiController extends Controller
{
    public function create()
    {
        return view('admin.emkm.calk.tambahakumulasi');
    }

    public function store(Request $request)
    {
        $a = new Akumulasi;
        $a->id_user = auth()->user()->id;
        $a->nama_aset = $request->nama_aset;
        $a->nilai_aset = $request->nilai_aset;
        $a->jumlah_unit = $request->jumlah_unit;
        $a->total_harga = $request->nilai_aset * $request->jumlah_unit;

        $a->save();

        return redirect('/emkm/calk')->with('success','Tambah akumulasi berhasil!');
    }
}
