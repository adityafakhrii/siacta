<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Akun;
use Illuminate\Http\Request;

class EMKMposisikeuanganController extends Controller
{
    public function index()
    {

        $dua = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','like','2%')
                        ->orderBy('no_akun','asc');

        $enam = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','like','6%')
                        ->orderBy('no_akun','asc');


        $asetlancar = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','like','1%')
                        ->union($dua)
                        ->orderBy('no_akun','asc')
                        ->get();

        $asettetapdebit = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','like','3%')
                        ->where('saldo_normal','=','debit')
                        ->orderBy('no_akun','asc')
                        ->get();

        $asettetapkredit = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','like','3%')
                        ->where('saldo_normal','=','kredit')
                        ->orderBy('no_akun','asc')
                        ->get();

        $asettidakberwujud = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','like','4%')
                        ->orderBy('no_akun','asc')
                        ->get();

        $kewajiban = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','like','5%')
                        ->union($enam)
                        ->orderBy('no_akun','asc')
                        ->get();

        $ekuitas = DB::table('bukubesarpenyesuaians')
                        ->join('akuns','bukubesarpenyesuaians.id_akun','=','akuns.id')
                        ->where('saldo','!=',0)
                        ->whereRaw('bukubesarpenyesuaians.id IN ( SELECT MAX(id) FROM bukubesarpenyesuaians GROUP BY id_akun)')
                        ->where('no_akun','like','7%')
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

        $total_labarugi = $laba_kotor - $total_beban;

        $saldolaba = Akun::where('no_akun','=','70.07.01')->get();
        $saldorugi = Akun::where('no_akun','=','70.07.02')->get();                

        return view('admin.emkm.posisikeuangan.posisikeuangan',compact('asetlancar','asettetapdebit','asettetapkredit','asettidakberwujud','kewajiban','ekuitas','total_labarugi','saldolaba','saldorugi'));
    }
}