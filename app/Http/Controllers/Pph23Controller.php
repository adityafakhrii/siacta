<?php

namespace App\Http\Controllers;
use App\Models\Pph23;
// use App\Models\Lampiranpph23;
use App\Models\Buktipph23;
use Auth;
use Illuminate\Http\Request;

class Pph23Controller extends Controller
{
    public function index()
    {
        $pph23 = Pph23::where('id_user','=', Auth::user()->id)->get();

        return view('admin.pajak.pph23.pph23',compact('pph23'));

    }

    public function create()
    {
        return view('admin.pajak.pph23.tambahpph23');
    }

    public function store(Request $request)
    {

        $pph23 = Pph23::create($request->all());

        if (!empty($request->input('nama_lampiran'))) {
            
            $checkid = implode(", ", $request->get('nama_lampiran'));

            $lam = new Lampiranpph23;
            $lam->id_user = Auth::user()->id;
            $lam->id_pph23 = $pph23->id;
            $lam->nama_lampiran = $checkid;
            $lam->lembar_importir  = $request->lembar_importir;
            $lam->lembar_importir  = $request->lembar_importir;
            $lam->save();

        }else{
            $lam = new Lampiranpph23;
            $lam->id_user = Auth::user()->id;
            $lam->id_pph23 = $pph23->id;
            $lam->nama_lampiran = 'Tidak Ada Lampiran';
            $lam->lembar_importir  = NULL;
            $lam->lembar_importir  = NULL;
            $lam->save();
        }

        return redirect('/pph23')->with('create','Tambah SPT Berhasil!');
    }


    //Bupot
    public function bupot()
    {
        $bupot = Buktipph23::where('id_user','=', Auth::user()->id)->get();

        return view('admin.pajak.pph23.bupot23',compact('bupot'));
    }

    public function create_bupot()
    {
        return view('admin.pajak.pph23.tambahbupot23');
    }

    public function store_bupot(Request $request)
    {

        Buktipph23::create($request->all());

        return redirect('/pph23/bukti-potong')->with('create','Tambah Bukti Potong Berhasil!');
    }
}
