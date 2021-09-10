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
                    ->where('saldo', '!=', 0)
                    ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                    ->where('no_akun', 'like', '9%')
                    ->where('saldo_normal','!=','kredit')
                    ->where('id_user','=',auth()->user()->id)
                    ->orWhere('no_akun','=','81.03.00')
                    ->where('keterangan','!=','Saldo Awal')
                    ->get();

        $jurnalpenutup81 = DB::table('bukubesarpenyesuaians')
                    ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                    ->where('saldo', '!=', 0)
                    // ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                    ->where('no_akun', 'like', '81%')
                    ->where('saldo_normal','!=','debit')
                    ->where('id_user','=',auth()->user()->id)
                    ->orWhere('no_akun','=','91.13.00')
                    ->where('keterangan','!=','Saldo Awal')
                    ->get();           

        $ikhtisar = Akun::where('no_akun','=','70.08.00')->get();

        $labarugi_pendapatan = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','like','81%')
                        ->where('no_akun','!=','81.03.00')
                        ->orderBy('no_akun','asc')
                        ->get();

        $potongan_penjualan = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','=','81.03.00')
                        ->get();

        $potongan_pembelian = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','=','91.13.00')
                        ->get();

        $labarugi_beban = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','like','91%')
                        ->where('no_akun','!=','91.13.00')
                        ->orderBy('no_akun','asc')
                        ->get();


        $total_pendapatan = 0;
        foreach ($labarugi_pendapatan as $lr) {
            $total_pendapatan += $lr->saldo;
        }

        $total_ppen = 0;
        foreach($potongan_penjualan as $ppen) {
            $total_ppen += $ppen->saldo;
        }

        $pendapatan_bersih = $total_pendapatan - $total_ppen;

        $total_ppem = 0;
        foreach ($potongan_pembelian as $ppem) {
            $total_ppem += $ppem->saldo;
        }

        $laba_kotor = $pendapatan_bersih + $total_ppem;

        //////////

        $total_beban = 0;
        foreach($labarugi_beban as $lb) {
            $total_beban += $lb->saldo;
        }

        $total_semua = $laba_kotor - $total_beban;

        $pajak = $total_pendapatan * (0.5/100);
        $total_labarugi = $total_semua - $pajak;

        $modals = Akun::where('no_akun','=','70.06.00')->get();
        $saldolaba = Akun::where('no_akun','=','70.07.01')->get();
        $saldorugi = Akun::where('no_akun','=','70.07.02')->get();


        return view('admin.jurnalpenutup.jurnalpenutup',compact('jurnalpenutup91','jurnalpenutup81','ikhtisar','total_labarugi','modals','saldolaba','saldorugi'));
    }
}
