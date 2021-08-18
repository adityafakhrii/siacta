<?php

namespace App\Http\Controllers;
use App\Models\Jurnalumum;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JurnalumumController extends Controller
{
    public function index(Request $request){
		
		// Carbon::parseFromFormat('Y-m-d');

    	if ($request->has('tgl')) {
	    		$tgl = $request->get('tgl');
	    		$jurnalumum = Jurnalumum::whereHas('transaksi',function ($query){
	            $query->where('id_user','=',Auth::user()->id);
	        })->where('tgl','like','%'.$tgl.'%')->orderBy('created_at','DESC')->get();
    	}else{
	    	$jurnalumum = Jurnalumum::whereHas('transaksi',function ($query){
	            $query->where('id_user','=',Auth::user()->id);
	        })
	        ->whereHas('transaksi',function ($query){
	            $query->where('tgl','=',date('d/m/Y'));
	        })->orderBy('created_at','DESC')->get();
    	}


        return view('admin.jurnalumum.jurnalumum',compact('jurnalumum'));
    }
}
