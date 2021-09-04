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
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','not like','81%')
                        ->where('no_akun','not like','91%')
                        ->orderBy('no_akun','asc')
                        ->get();



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

        $pajak = 0;
        // $pajak = $total_pendapatan * (0.5/100);
        $total_labarugi = $total_semua - $pajak;

        $modals = Akun::where('no_akun','=','70.06.00')->get();
          

        return view('admin.neracapenutup.neracapenutup',compact('neracapenutup','total_labarugi','modals'));
    }
}
