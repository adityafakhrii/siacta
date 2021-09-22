<?php

namespace App\Http\Controllers;
use App\Models\Pph22;
use App\Models\Lampiranpph22;
use App\Models\Buktipph22;
use Auth;
use Illuminate\Http\Request;

class Pph22Controller extends Controller
{

    public function index()
    {
        $pph22 = Pph22::where('id_user','=', Auth::user()->id)->get();

        return view('admin.pajak.pph22.pph22',compact('pph22'));

    }

    public function create()
    {
        return view('admin.pajak.pph22.tambahpph22');
    }

    public function store(Request $request)
    {

        $pph22 = Pph22::create($request->all());

        if (!empty($request->input('nama_lampiran'))) {
            
            $checkid = implode(", ", $request->get('nama_lampiran'));

            $lam = new Lampiranpph22;
            $lam->id_user = Auth::user()->id;
            $lam->id_pph22 = $pph22->id;
            $lam->nama_lampiran = $checkid;
            $lam->lembar_importir  = $request->lembar_importir;
            $lam->lembar_importir  = $request->lembar_importir;
            $lam->save();

        }else{
            $lam = new Lampiranpph22;
            $lam->id_user = Auth::user()->id;
            $lam->id_pph22 = $pph22->id;
            $lam->nama_lampiran = 'Tidak Ada Lampiran';
            $lam->lembar_importir  = NULL;
            $lam->lembar_importir  = NULL;
            $lam->save();
        }

        return redirect('/pph22')->with('create','Tambah SPT Berhasil!');
    }


    //Bupot
    public function bupot()
    {
        $bupot = Buktipph22::where('id_user','=', Auth::user()->id)->get();

        return view('admin.pajak.pph22.bupot22',compact('bupot'));
    }

    public function create_bupot()
    {
        return view('admin.pajak.pph22.tambahbupot22');
    }

    public function store_bupot(Request $request)
    {

        Buktipph22::create($request->all());

        return redirect('/pph22/bukti-potong')->with('create','Tambah Bukti Potong Berhasil!');
    }
}
