<?php

namespace App\Http\Controllers;
// use App\Models\Pph21;
use Illuminate\Http\Request;

class Pph21Controller extends Controller
{
    public function index()
    {
        // $pph21 = Pph21::all();
        return view('admin.pajak.pph21.pph21');
    }

    public function create()
    {
        return view('admin.pajak.pph21.tambahpph21');
    }
}
