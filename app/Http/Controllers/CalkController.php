<?php

namespace App\Http\Controllers;
use App\Models\Aset;
use App\Models\Akumulasi;
use App\Models\Piutangusaha;
use App\Models\Kasbank;
use App\Models\Investasipendek;
use App\Models\Piutangnon;
use App\Models\Perlengkapan;
use App\Models\Pembayaranmuka;
use App\Models\Asetlain;
use App\Models\Investasipanjang;
use App\Models\Asettetap;
use App\Models\Asetleasing;
use Illuminate\Http\Request;

class CalkController extends Controller
{
    public function index()
    {
        $asets = Aset::where('id_user','=',auth()->user()->id)->get();
        $akumulasis = Akumulasi::where('id_user','=',auth()->user()->id)->get();
        $piutangs = Piutangusaha::where('id_user','=',auth()->user()->id)->get();
        $kasbanks = Kasbank::where('id_user','=',auth()->user()->id)->get();
        $investasipendek = Investasipendek::where('id_user','=',auth()->user()->id)->get();
        $nonusaha = Piutangnon::where('id_user','=',auth()->user()->id)->get();
        $perlengkapan = Perlengkapan::where('id_user','=',auth()->user()->id)->get();
        $pembayaran = Pembayaranmuka::where('id_user','=',auth()->user()->id)->get();
        $asetlain = Asetlain::where('id_user','=',auth()->user()->id)->get();
        $investasipanjang = Investasipanjang::where('id_user','=',auth()->user()->id)->get();
        $asettetap = Asettetap::where('id_user','=',auth()->user()->id)->get();
        $asetleasing = Asetleasing::where('id_user','=',auth()->user()->id)->get();

        return view('admin.emkm.calk.calk',compact('asets','akumulasis','piutangs','kasbanks','investasipendek','nonusaha','perlengkapan','pembayaran','asetlain','investasipanjang','asettetap','asetleasing'));
    }
}
