<?php

namespace App\Http\Controllers;
use App\Models\Neracasaldoawal;
use App\Models\Akun;
use Auth;
use DB;
use Illuminate\Http\Request;

class BumdesController extends Controller
{
    public function neracaawal()
    {
        // $neracasaldoawal = Neracasaldoawal::whereHas('akun',function ($query){
        //     $query->whereHas('user',function($query){
        //             $query->where('role','=','unitusaha');
        //     });
        // })
        // ->get();

        $neracasaldoawal = DB::table('neracasaldoawals')
                                ->join('akuns','neracasaldoawals.id_akun','=','akuns.id')
                                ->join('users','akuns.id_users','=','users.id')
                                ->where('users.role','=','unitusaha')
                                ->get();

        return view('admin.neracasaldoawal.index',compact('neracasaldoawal'));
    }
}