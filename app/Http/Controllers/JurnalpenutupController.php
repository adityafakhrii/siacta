<?php

namespace App\Http\Controllers;
use App\Models\Jurnalpenutup;
use App\Models\Akun;
use Illuminate\Http\Request;
use DB;

class JurnalpenutupController extends Controller
{
    public function index()
    {
        // $jurnalpenutup = Jurnalpenutup::where('id_user','=',auth()->user()->id)->orderBy('created_at','DESC')->get();

        $jurnalpenutup91 = DB::table('bukubesarpenyesuaians')
                    ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                    ->where('id_user','=',auth()->user()->id)
                    ->where('saldo', '!=', 0)
                    ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                    ->where('no_akun', 'like', '9%')
                    ->where('saldo_normal','!=','kredit')
                    ->orWhere(function($query){
                        $query->where('no_akun','=','81.06.00');
                        $query->orWhere('no_akun','=','81.07.00');
                        $query->orWhere('no_akun','=','81.05.00');
                    })
                    ->where('keterangan','!=','Saldo Awal')
                    ->get();

        $jurnalpenutup81 = DB::table('bukubesarpenyesuaians')
                    ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                    ->where('saldo', '!=', 0)
                    ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                    ->where('no_akun', 'like', '8%')
                    ->where('saldo_normal','!=','debit')
                    ->where('id_user','=',auth()->user()->id)
                    ->orWhere(function($query){
                        $query->where('no_akun','=','91.01.04');
                        $query->orWhere('no_akun','=','91.01.02');
                        $query->orWhere('no_akun','=','91.01.03');
                    })
                    ->where('keterangan','!=','Saldo Awal')
                    ->get();           

        $ikhtisar = Akun::where([
            ['id_user','=',auth()->user()->id],
            ['no_akun','=','70.12.00']
        ])->get();       



        $labarugi_pendapatan = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('id_user','=',auth()->user()->id)
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','like','8%')
                        ->where(function($query){
                            $query->where('no_akun','!=','81.06.00');
                            $query->orWhere('no_akun','!=','81.07.00');
                            $query->orWhere('no_akun','!=','81.05.00');
                        })
                        ->orderBy('no_akun','asc')
                        ->get();

        $labarugi_beban = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('id_user','=',auth()->user()->id)
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','like','9%')
                        ->Where(function($query){
                            $query->where('no_akun','!=','91.01.02');
                            $query->orWhere('no_akun','!=','91.01.03');
                            $query->orWhere('no_akun','!=','91.01.04');
                        })
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

        if ($total_semua > 0) {
          $pajak = $total_semua * (0.5/100);
        }else{
          $pajak = 0;
        }

        $total_labarugi = $total_semua - $pajak;

        $modals = Akun::where('id_user','=',auth()->user()->id)->where('no_akun','=','70.06.00')->get();
        $saldolaba = Akun::where('id_user','=',auth()->user()->id)->where('no_akun','=','70.07.00')->get();
        $saldorugi = Akun::where('id_user','=',auth()->user()->id)->where('no_akun','=','70.08.00')->get();


        return view('admin.jurnalpenutup.jurnalpenutup',compact('jurnalpenutup91','jurnalpenutup81','ikhtisar','total_labarugi','modals','saldolaba','saldorugi'));
    }
}
