<?php

namespace App\Http\Controllers;
use App\Models\Pph4ayat2;
use Auth;
use Illuminate\Http\Request;

class Pph4ayat2Controller extends Controller
{
    public function index()
    {
        $pph4ayat2 = Pph4ayat2::where('id_user','=', Auth::user()->id)->get();

        return view('admin.pajak.pph4ayat2.pph4ayat2',compact('pph4ayat2'));

    }

    public function create()
    {
        return view('admin.pajak.pph4ayat2.tambahpph4ayat2');
    }

    public function store(Request $request)
    {

        $pph4ayat2 = Pph4ayat2::create($request->all());

        return redirect('/pph4ayat2')->with('create','Tambah SPT Berhasil!');
    }
}
