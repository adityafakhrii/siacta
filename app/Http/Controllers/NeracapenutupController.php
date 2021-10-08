<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Akun;
use Illuminate\Http\Request;

class NeracapenutupController extends Controller
{
    public function index()
    {
        $neracapenutup = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('id_user','=',auth()->user()->id)
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','not like','8%')
                        ->where('no_akun','not like','9%')
                        ->orderBy('no_akun','asc')
                        ->get();

        $labarugi_pendapatan = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('id_user','=',auth()->user()->id)
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','like','8%')
                        ->where('no_akun','!=','81.06.00')
                        ->orderBy('no_akun','asc')
                        ->get();

        $labarugi_beban = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('id_user','=',auth()->user()->id)
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','like','9%')
                        ->orderBy('no_akun','asc')
                        ->get();

        $total_pendapatan = 0;
        foreach ($labarugi_pendapatan as $lr) {
            $total_pendapatan += $lr->saldo;
        }

        $total_beban = 0;
        foreach($labarugi_beban as $lb) {
            $total_beban += $lb->saldo;
        }

        $total_semua = $total_pendapatan - $total_beban;

        $pajak = 0;
        // $pajak = $total_pendapatan * (0.5/100);
        $total_labarugi = $total_semua - $pajak;

        $modals = Akun::where('id_user','=',auth()->user()->id)->where('no_akun','=','70.06.00')->get();
          

        return view('admin.neracapenutup.neracapenutup',compact('neracapenutup','total_labarugi','modals'));
    }
}
