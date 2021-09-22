<?php

namespace App\Http\Controllers;
use App\Models\Pph21;
use App\Models\Lampiran;
use App\Models\Buktipph21tidaktetap;
use App\Models\Buktipph21tetap;
use Auth;
use DB;
use Illuminate\Http\Request;

class Pph21Controller extends Controller
{
    public function index()
    {
        $pph21 = Pph21::where('id_user','=', Auth::user()->id)->get();

        return view('admin.pajak.pph21.pph21',compact('pph21'));

    }

    public function create()
    {
        return view('admin.pajak.pph21.tambahpph21');
    }

    public function store(Request $request)
    {

        $pph21 = Pph21::create($request->all());

        if (!empty($request->input('nama_lampiran'))) {
            
            $checkid = implode(", ", $request->get('nama_lampiran'));

            $lam = new Lampiran;
            $lam->id_user = Auth::user()->id;
            $lam->id_pph21 = $pph21->id;
            $lam->nama_lampiran = $checkid;
            $lam->save();

        }else{
            $lam = new Lampiran;
            $lam->id_user = Auth::user()->id;
            $lam->id_pph21 = $pph21->id;
            $lam->nama_lampiran = 'Tidak Ada Lampiran';
            $lam->save();
        }
        return redirect('/pph21')->with('create','Tambah SPT Berhasil!');
    }



    //Bupot Tidak tetap
    public function bupot_tidak()
    {
        $bupot = Buktipph21tidaktetap::where('id_user','=', Auth::user()->id)->get();

        return view('admin.pajak.pph21.buktipotongtidak',compact('bupot'));
    }

    public function create_bupot_tidak()
    {
        return view('admin.pajak.pph21.tambahbuktipotongtidak');
    }

    public function store_bupot_tidak(Request $request)
    {

        Buktipph21tidaktetap::create($request->all());

        return redirect('/pph21/bukti-potong-tidaktetap')->with('create','Tambah Bukti Potong Tidak Tetap Berhasil!');
    }


    //Bupot tetap
    public function bupot_tetap()
    {
        $bupot = Buktipph21tetap::where('id_user','=', Auth::user()->id)->get();

        return view('admin.pajak.pph21.buktipotongtetap',compact('bupot'));
    }

    public function create_bupot_tetap()
    {
        return view('admin.pajak.pph21.tambahbuktipotongtetap');
    }

    public function store_bupot_tetap(Request $request)
    {

        Buktipph21tetap::create($request->all());

        return redirect('/pph21/bukti-potong-tetap')->with('create','Tambah Bukti Potong Tetap Berhasil!');
    }
}